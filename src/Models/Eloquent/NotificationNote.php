<?php

namespace WithCandour\StatamicAdvancedForms\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;
use WithCandour\StatamicAdvancedForms\Contracts\Models\NotificationNote as Contract;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Facades\Notification as NotificationFacade;
use WithCandour\StatamicAdvancedForms\Facades\Submission as SubmissionFacade;
use WithCandour\StatamicAdvancedForms\Models\NoteType;

class NotificationNote extends Model implements Contract
{
    use HasTimestamps;

    const UPDATED_AT = null;

    protected $table = 'advanced_forms_notification_notes';

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
    public function notification(): Notification
    {
        return NotificationFacade::find($this->notification_id);
    }

    /**
     * @inheritDoc
     */
    public function setNotification(Notification $notification): self
    {
        $this->notification_id = $notification->id();
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
