<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP;

use Illuminate\Http\Request;
use Statamic\CP\Breadcrumbs;
use Statamic\CP\Column;
use Statamic\Extensions\Pagination\LengthAwarePaginator;
use Statamic\Facades\Config;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;
use WithCandour\StatamicAdvancedForms\Facades\Submission as SubmissionFacade;
use WithCandour\StatamicAdvancedForms\Http\Resources\CP\Submissions;

class SubmissionsController extends Controller
{
    public function index(string $formId, Request $request)
    {
        $this->authorize('access advanced forms submissions');

        if (!$form = FormFacade::find($formId)) {
            return $this->pageNotFound();
        }

        $submissions = \collect($form->submissions())
            ->sortByDesc(function (Submission $submission) {
                return $submission->date()->timestamp;
            });

        if ($request->ajax()) {
            $submissionsCount = $submissions->count();
            $perPage = request('perPage') ?? Config::get('statamic.cp.pagination_size');
            $currentPage = (int) request('page') ?? 1;
            $offset = ($currentPage - 1) * $perPage;
            $submissions = $submissions->slice($offset, $perPage);
            $paginator = new LengthAwarePaginator($submissions, $submissionsCount, $perPage, $currentPage);

            return (new Submissions($paginator))
                ->blueprint($form->blueprint())
                ->columnPreferenceKey("advanced-forms.{$form->id()}.columns");
        }

        $breadcrumb = Breadcrumbs::make([
            [
                'text' => __('advanced-forms::messages.title'),
                'url' => cp_route('advanced-forms.index'),
            ],
            [
                'text' => $form->title(),
                'url' => $form->showUrl(),
            ],
            [
                'text' => __('Submissions'),
                'url' => $form->submissionsUrl(),
            ],
        ]);

        return view('advanced-forms::cp.submissions.index', [
            'title' => __('Submissions'),
            'form' => $form,
            'submissions_initial_columns' => [
                Column::make('date')->label(__('Date')),
            ],
            'action_url' => cp_route('advanced-forms.submissions.actions.run'),
            'breadcrumb' => $breadcrumb,
            'submissions' => $submissions,
        ]);
    }

    public function show(string $formId, string $submissionId)
    {
        $this->authorize('access advanced forms submissions');

        /**
         * @var Form|null
         */
        if (!$form = FormFacade::find($formId)) {
            return $this->pageNotFound();
        }

        /**
         * @var Submission|null
         */
        if (!$submission = SubmissionFacade::find($submissionId)) {
            return $this->pageNotFound();
        }

        if (!$submission->belongsToForm($form)) {
            return $this->pageNotFound();
        }

        $blueprint = $form->blueprint();
        $fields = $blueprint->fields()->addValues($submission->values()?->data() ?? [])->preProcess();

        $title = $submission->date()->format('M j, Y @ H:i');

        $breadcrumb = Breadcrumbs::make([
            [
                'text' => __('advanced-forms::messages.title'),
                'url' => cp_route('advanced-forms.index'),
            ],
            [
                'text' => $form->title(),
                'url' => $form->showUrl(),
            ],
            [
                'text' => __('Submissions'),
                'url' => $form->submissionsUrl(),
            ],
            [
                'text' => $title,
                'url' => $submission->showUrl(),
            ]
        ]);

        return view('advanced-forms::cp.submissions.show', [
            'form' => $form,
            'submission' => $submission,
            'blueprint' => $blueprint->toPublishArray(),
            'breadcrumb' => $breadcrumb,
            'values' => $fields->values(),
            'meta' => $fields->meta(),
            'title' => $title,
        ]);
    }
}
