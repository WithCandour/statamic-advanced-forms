<?php

namespace WithCandour\StatamicAdvancedForms\Repositories\Eloquent;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission as SubmissionContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\SubmissionsRepository as Contract;
use WithCandour\StatamicAdvancedForms\Models\Eloquent\Submission;

class SubmissionsRepository implements Contract
{
    /**
     * @inheritDoc
     */
    public function make(Form $form): SubmissionContract
    {
        $submission = new Submission();
        $submission->setForm($form);

        return $submission;
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return Submission::query()
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?SubmissionContract
    {
        return Submission::query()
            ->where('id', $id)
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function findByForm(Form $form): Collection
    {
        return Submission::query()
            ->where('form_id', $form->id())
            ->get();
    }
}
