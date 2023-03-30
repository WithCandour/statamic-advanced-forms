<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Repositories;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;

interface SubmissionsRepository
{
    /**
     * Create a new submission for a form.
     *
     * @param Form $form
     * @return Submission
     */
    public function make(Form $form): Submission;

    /**
     * Return all submissions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection;

    /**
     * Find a submission by it's ID.
     *
     * @param string $id
     * @return Submission|null
     */
    public function find(int $id): ?Submission;

    /**
     * Find all submissions for a given form.
     *
     * @param Form $form
     * @return Collection
     */
    public function findByForm(Form $form): Collection;
}
