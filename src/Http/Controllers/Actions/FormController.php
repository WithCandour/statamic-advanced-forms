<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Statamic\Fields\Field;
use Statamic\Fields\Fields;
use Statamic\Support\Str;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Processors\FeedProcessor;
use WithCandour\StatamicAdvancedForms\Contracts\Processors\NotificationProcessor;
use WithCandour\StatamicAdvancedForms\Events\AdvancedFormSubmitting;
use WithCandour\StatamicAdvancedForms\Exceptions\AdvancedFormNotFoundException;
use WithCandour\StatamicAdvancedForms\Exceptions\AdvancedFormSubmissionRejectedException;
use WithCandour\StatamicAdvancedForms\Facades\Form;
use WithCandour\StatamicAdvancedForms\Forms\Rules\UniqueSubmission;
use WithCandour\StatamicAdvancedForms\Models\Stache\Form as StacheForm;

class FormController extends Controller
{
    const FORM_SESSION_PREFIX = 'advanced_form.';

    const ASSET_FIELDTYPES = [
        'assets',
        'anonymous_assets'
    ];

    protected FeedProcessor $feedProcessor;

    protected NotificationProcessor $notificationProcessor;

    /**
     * @param FeedProcessor $feedProcessor
     */
    public function __construct(FeedProcessor $feedProcessor, NotificationProcessor $notificationProcessor)
    {
        $this->feedProcessor = $feedProcessor;
        $this->notificationProcessor = $notificationProcessor;
    }

    /**
     * Handle a form submission.
     */
    public function submit(Request $request, string $handle)
    {
        /**
         * @var \WithCandour\StatamicAdvancedForms\Contracts\Models\Form
         */
        $form = Form::find($handle);

        if (!$form) {
            throw new AdvancedFormNotFoundException($handle);
        }

        $requestValues = \collect($request->all())
            ->filter(fn ($value, $key) => !Str::startsWith($key, '_'))
            ->all();

        $fields = $form
            ->blueprint()
            ->fields();

        $assetValues = $this->normalizeAssetsValues($fields, $request);

        $submissionValues = \array_merge($requestValues, $assetValues);

        $fieldValues = $fields->addValues($submissionValues);

        $submission = $form->makeSubmission();

        try {
            $fieldValues->validate(
                $this->extraRules($form, $fieldValues)
            );

            // Allow listeners to reject forms (captcha etc)
            throw_if(AdvancedFormSubmitting::dispatch($form, $submissionValues) === false, new AdvancedFormSubmissionRejectedException);

            $submissionValues = \array_merge($submissionValues, $submission->uploadFiles($assetValues));

            $submission->save();
        } catch (ValidationException $validationException) {
            return $this->formFailure($validationException->errors(), $form->handle());
        } catch (AdvancedFormSubmissionRejectedException $rejectionException) {
            return $this->formSuccess();
        }

        // Save the submission values
        $submissionValues = $submission
            ->makeValues()
            ->data($fields->addValues($submissionValues)->process()->values());

        $submissionValues->save();

        $this->feedProcessor->process($submission);
        $this->notificationProcessor->process($submission);

        return $this->formSuccess($submission);
    }

    /**
     * Return a fail state.
     *
     * @param array $errors
     * @param string $formHandle
     */
    private function formFailure(array $errors, string $formHandle)
    {
        if (request()->ajax()) {
            return response([
                'errors' => (new MessageBag($errors))->all(),
                'error' => \collect($errors)
                    ->map(fn ($errors, $field) => $errors[0] ?? null)
                    ->all(),
            ], 400);
        }

        $response = back();

        return $response->withInput()->withErrors($errors, self::FORM_SESSION_PREFIX . $formHandle);
    }

    /**
     * Return a success state.
     *
     * @param Submission|null $submission
     */
    private function formSuccess(?Submission $submission = null)
    {
        if (request()->ajax()) {
            return response([
                'success' => true,
                'submission' => $submission?->id() ?? null,
            ]);
        }

        $formHandle = $submission->form()->handle();

        session()->flash(self::FORM_SESSION_PREFIX . $formHandle . '.success', __('Submission successful'));

        return back();
    }

    /**
     * Normalize the values for any assets fieldtypes.
     *
     * @param Fields $fields
     * @param Request $request
     * @return array
     */
    protected function normalizeAssetsValues(Fields $fields, Request $request): array
    {
        return $fields
            ->all()
            ->filter(function (Field $field) {
                return \in_array($field->fieldtype()->handle(), self::ASSET_FIELDTYPES) &&
                request()->hasFile($field->handle());
            })
            ->map(function (Field $field) use ($request) {
                return Arr::wrap($request->file($field->handle()));
            })
            ->all();
    }

    /**
     * Get extra validation rules for the submission
     *
     * @param Fields $fields
     * @return array
     */
    protected function extraRules(StacheForm $form, Fields $fields): array
    {
        $uniqueFieldRules = $fields->all()
            ->filter(function ($field) {
                return $field->config()['submissions_unique'] ?? null;
            })
            ->mapWithKeys(function ($field) use ($form) {
                return [$field->handle() => [new UniqueSubmission($form, $field->handle())]];
            })
            ->all();

        $assetFieldRules = $fields->all()
            ->filter(function ($field) {
                return \in_array($field->fieldtype()->handle(), self::ASSET_FIELDTYPES);
            })
            ->mapWithKeys(function ($field) {
                return [$field->handle().'.*' => 'file'];
            })
            ->all();

        return array_merge($uniqueFieldRules, $assetFieldRules);
    }
}
