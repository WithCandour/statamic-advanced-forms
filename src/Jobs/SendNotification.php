<?php

namespace WithCandour\StatamicAdvancedForms\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Mail\NotificationEmail;
use WithCandour\StatamicAdvancedForms\Models\NoteType;

class SendNotification
{
    use Dispatchable, SerializesModels;

    public function __construct(
        protected Notification $notification,
        protected Submission $submission
    ) {}

    public function handle()
    {
        $sent = false;
        $notificationSentNotification = $this->submission->makeNoteForNotification($this->notification);

        try {
            $sent = Mail::send(new NotificationEmail($this->notification, $this->submission));
        } catch (\Exception $e) {
            $notificationSentNotification->setNoteType(NoteType::ERROR);
            $notificationSentNotification->setNote($e->getMessage());
            $notificationSentNotification->save();
            return;
        }

        if ($sent) {
            $notificationSentNotification->setNoteType(NoteType::SUCCESS);
            $notificationSentNotification->setNote('Sent notification.');

        } else {
            $notificationSentNotification->setNoteType(NoteType::ERROR);
            $notificationSentNotification->setNote('Could not send notification.');
        }

        $notificationSentNotification->save();
    }
}
