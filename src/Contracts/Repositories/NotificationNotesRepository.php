<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Repositories;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;
use WithCandour\StatamicAdvancedForms\Contracts\Models\NotificationNote;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;

interface NotificationNotesRepository
{
    /**
     * Make a notifiation note for a given submission and notification.
     *
     * @param Submission $submission
     * @param Notification $notification
     * @return NotificationNote
     */
    public function make(Submission $submission, Notification $notification): NotificationNote;

    /**
     * Get all notification notes for a submission.
     *
     * @param Submission $submission
     * @return Collection
     */
    public function findBySubmission(Submission $submission): Collection;
}
