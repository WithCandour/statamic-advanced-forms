<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Repositories;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Models\SubmissionValues;
use WithCandour\StatamicAdvancedForms\Models\Stache\Form;

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
     * @return SubmissionValues|null
     */
    public function findBySubmission(Submission $submission): ?SubmissionValues;

    /**
     * Find the submission values for a given form.
     *
     * @param Form $form
     * @return SubmissionValues|null
     */
    public function findByForm(Form $form): ?Collection;
}
