<?php

namespace WithCandour\StatamicAdvancedForms\Repositories\Eloquent;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;
use WithCandour\StatamicAdvancedForms\Contracts\Models\NotificationNote as NotificationNoteContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\NotificationNotesRepository as Contract;
use WithCandour\StatamicAdvancedForms\Models\Eloquent\NotificationNote;

class NotificationNotesRepository implements Contract
{
    /**
     * @inheritDoc
     */
    public function make(Submission $submission, Notification $notification): NotificationNoteContract
    {
        $note = new NotificationNote();
        $note->setSubmission($submission);
        $note->setNotification($notification);

        return $note;
    }

    /**
     * @inheritDoc
     */
    public function findBySubmission(Submission $submission): Collection
    {
        return NotificationNote::query()
            ->where('submission_id', $submission->id())
            ->get();
    }
}
