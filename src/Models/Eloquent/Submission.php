<?php

namespace WithCandour\StatamicAdvancedForms\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;
use WithCandour\StatamicAdvancedForms\Contracts\Models\FeedNote;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;
use WithCandour\StatamicAdvancedForms\Contracts\Models\NotificationNote;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission as Contract;
use WithCandour\StatamicAdvancedForms\Contracts\Models\SubmissionValues;
use WithCandour\StatamicAdvancedForms\Facades\FeedNote as FeedNoteFacade;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;
use WithCandour\StatamicAdvancedForms\Facades\NotificationNote as NotificationNoteFacade;
use WithCandour\StatamicAdvancedForms\Facades\SubmissionValues as SubmissionValuesFacade;

class Submission extends Model implements Contract
{
    protected $table = 'advanced_forms_submissions';

    protected $casts = [
        'created_at' => 'datetime'
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
    public function form(): ?Form
    {
        return FormFacade::find($this->form_id);
    }

    /**
     * @inheritDoc
     */
    public function makeValues(): SubmissionValues
    {
        return SubmissionValuesFacade::make($this);
    }

    /**
     * @inheritDoc
     */
    public function values(): SubmissionValues
    {
        return SubmissionValuesFacade::findBySubmission($this);
    }

    /**
     * @inheritDoc
     */
    public function setForm(Form $form): self
    {
        $this->form_id = $form->id();
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function makeNoteForNotification(Notification $notification): NotificationNote
    {
        return NotificationNoteFacade::make($this, $notification);
    }

    /**
     * @inheritDoc
     */
    public function notificationNotes(): Collection
    {
        return NotificationNoteFacade::findBySubmission($this);
    }

    /**
     * @inheritDoc
     */
    public function makeNoteForFeed(Feed $feed): FeedNote
    {
        return FeedNoteFacade::make($this, $feed);
    }

    /**
     * @inheritDoc
     */
    public function feedNotes(): Collection
    {
        return FeedNoteFacade::findBySubmission($this);
    }

    /**
     * @inheritDoc
     */
    public function showUrl(): string
    {
        return cp_route(
            'advanced-forms.submissions.show',
            [
                'advanced_form' => $this->form()->id(),
                'submission' => $this->id(),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function deleteUrl(): string
    {
        return cp_route(
            'advanced-forms.notifications.destroy',
            [
                'advanced_form' => $this->form()->id(),
                'submission' => $this->id(),
            ]
        );
    }
}
