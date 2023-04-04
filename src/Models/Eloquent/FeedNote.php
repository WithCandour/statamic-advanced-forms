<?php

namespace WithCandour\StatamicAdvancedForms\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;
use WithCandour\StatamicAdvancedForms\Contracts\Models\FeedNote as Contract;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Facades\Feed as FeedFacade;
use WithCandour\StatamicAdvancedForms\Facades\Submission as SubmissionFacade;
use WithCandour\StatamicAdvancedForms\Models\NoteType;

class FeedNote extends Model implements Contract
{
    protected $table = 'advanced_forms_external_feed_notes';

    protected $casts = [
        'created_at' => 'datetime',
        'type' => NoteType::class,
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
    public function date(): Carbon
    {
        return new Carbon($this->created_at);
    }

    /**
     * @inheritDoc
     */
    public function feed(): Feed
    {
        return FeedFacade::find($this->feed_id);
    }

    /**
     * @inheritDoc
     */
    public function setFeed(Feed $feed): self
    {
        $this->feed_id = $feed->id();
        return $this;
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
    public function noteType(): NoteType
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function setNoteType(NoteType $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function note(): ?string
    {
        return $this->note;
    }

    /**
     * @inheritDoc
     */
    public function setNote(string $note): self
    {
        $this->note = $note;
        return $this;
    }
}
