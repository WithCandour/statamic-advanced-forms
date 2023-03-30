<?php

namespace WithCandour\StatamicAdvancedForms\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Statamic\Data\ContainsData;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Models\SubmissionValues as Contract;
use WithCandour\StatamicAdvancedForms\Facades\Submission as SubmissionFacade;

class SubmissionValues extends Model implements Contract
{
    use ContainsData;

    protected $table = 'advanced_forms_submission_values';

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * @inheritDoc
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function submission(): Submission
    {
        return SubmissionFacade::find($this->submission_id);
    }

    /**
     * @inheritDoc
     */
    public function setSubmission(Submission $submission): self
    {
        $this->submission_id = $submission->id();
        return $this;
    }
}
