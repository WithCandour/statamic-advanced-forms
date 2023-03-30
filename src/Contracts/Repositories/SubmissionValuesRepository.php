<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Repositories;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Models\SubmissionValues;

interface SubmissionValuesRepository
{
    /**
     * Create a new submission values model for a submission.
     *
     * @param Submission $submission
     */
    public function make(Submission $submission): SubmissionValues;

    /**
     * Find the submission values for a given submission.
     *
     * @param Submission $submission
     * @return Collection
     */
    public function findBySubmission(Submission $submission): SubmissionValues;
}
