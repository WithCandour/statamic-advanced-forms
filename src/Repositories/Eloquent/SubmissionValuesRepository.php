<?php

namespace WithCandour\StatamicAdvancedForms\Repositories\Eloquent;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Models\SubmissionValues as SubmissionValuesContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\SubmissionValuesRepository as Contract;
use WithCandour\StatamicAdvancedForms\Models\Eloquent\SubmissionValues;
use WithCandour\StatamicAdvancedForms\Models\Stache\Form;
use Illuminate\Support\Collection;

class SubmissionValuesRepository implements Contract
{
    /**
     * @inheritDoc
     */
    public function make(Submission $submission): SubmissionValuesContract
    {
        $values = new SubmissionValues([
            'submission_id' => $submission->id(),
        ]);

        return $values;
    }

    /**
     * @inheritDoc
     */
    public function findBySubmission(Submission $submission): ?SubmissionValuesContract
    {
        return SubmissionValues::query()
            ->where('submission_id', $submission->id())
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function findByForm(Form $form): ?Collection
    {
        $values = collect();

        // get all form submissions
        $form->submissions()->each(function(Submission $submission) use ($values) {
            $values->push($this->findBySubmission($submission));
        });

        return $values;
    }
}
