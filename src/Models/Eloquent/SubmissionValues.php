<?php

namespace WithCandour\StatamicAdvancedForms\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Statamic\Contracts\Data\Augmentable;
use Statamic\Data\ContainsData;
use Statamic\Data\HasAugmentedData;
use Statamic\Fields\Blueprint;
use Statamic\Fields\Field;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Models\SubmissionValues as Contract;
use WithCandour\StatamicAdvancedForms\Facades\Submission as SubmissionFacade;

class SubmissionValues extends Model implements Contract
{
    use ContainsData;

    protected $table = 'advanced_forms_submission_values';

    protected $guarded = [];

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

    /**
     * @inheritDoc
     */
    public function get($key, $fallback = null)
    {
        return $this->data()[$key] ?? $fallback;
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value)
    {
        // No setting of submission values allowed
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function data($data = null)
    {
        if (func_num_args() === 0) {
            return $this->getAttribute('data');
        }

        $this->attributes['data'] = $data;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function blueprint(): Blueprint
    {
        return $this->submission()->form()->blueprint();
    }

    /**
     * @inheritDoc
     */
    public function toAugmentedArray(): array
    {
        return $this->blueprint()
            ->fields()
            ->addValues($this->data())
            ->augment()
            ->values()
            ->all();
    }
}
