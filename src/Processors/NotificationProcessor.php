<?php

namespace WithCandour\StatamicAdvancedForms\Processors;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Processors\NotificationProcessor as Contract;

class NotificationProcessor implements Contract
{
    /**
     * @inheritDoc
     */
    public function process(Submission $submission): void
    {
        $notificationsForSubmission = \collect($submission->form()->notifications())
            ->filter(fn (Notification $notification) => $notification->enabled())
            ->filter(fn (Notification $notification) => $notification->shouldSend($submission))
            ->values();

        ray($notificationsForSubmission)->green();

        $notificationsForSubmission->each(function (Notification $notification) use ($submission) {
            $notification->send($submission);
        });
    }
}
