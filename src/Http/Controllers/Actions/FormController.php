<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Statamic\Support\Str;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Exceptions\AdvancedFormNotFoundException;
use WithCandour\StatamicAdvancedForms\Facades\Form;

class FormController extends Controller
{
    const FORM_SESSION_PREFIX = 'advanced_form.';

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

        $submissionValues = \collect($request->all())
            ->filter(fn ($value, $key) => !Str::startsWith($key, '_'))
            ->all();

        $fields = $form
            ->blueprint()
            ->fields()
            ->addValues($submissionValues);

        $submission = $form->makeSubmission();

        try {
            $fields->validate();
            $submission->save();
        } catch (ValidationException $validationException) {
            return $this->formFailure($validationException->errors(), $form->handle());
        }

        // Save the submission values
        $submissionValues = $submission
            ->makeValues()
            ->data($fields->values());

        ray($submissionValues)->green();

        $submissionValues->save();

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
     * @param Submission $submission
     */
    private function formSuccess(Submission $submission)
    {
        if (request()->ajax()) {
            return response([
                'success' => true,
                'submission' => $submission->id(),
            ]);
        }

        $formHandle = $submission->form()->handle();

        session()->flash(self::FORM_SESSION_PREFIX . $formHandle . '.success', __('Submission successful'));

        return back();
    }
}
