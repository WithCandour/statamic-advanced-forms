<?php

namespace WithCandour\StatamicAdvancedForms\Repositories\Eloquent;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Models\SubmissionValues as SubmissionValuesContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\SubmissionValuesRepository as Contract;
use WithCandour\StatamicAdvancedForms\Models\Eloquent\SubmissionValues;

class SubmissionValuesRepository implements Contract
{
    /**
     * @inheritDoc
     */
    public function make(Submission $submission): SubmissionValuesContract
    {
        $values = new SubmissionValues();
        $values->setSubmission($submission);

        return $values;
    }

    /**
     * @inheritDoc
     */
    public function findBySubmission(Submission $submission): SubmissionValuesContract
    {
        return SubmissionValues::query()
            ->where('submission_id', $submission->id())
            ->first();
    }
}
