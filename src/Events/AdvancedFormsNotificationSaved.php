<?php

namespace WithCandour\StatamicAdvancedForms\Events;

use Statamic\Contracts\Git\ProvidesCommitMessage;
use Statamic\Events\Event;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;

class AdvancedFormsNotificationSaved extends Event implements ProvidesCommitMessage
{
    /**
     * @param Notification
     */
    public function __construct(
        public Notification $notification
    ) {}

    /**
     * @inheritDoc
     */
    public function commitMessage()
    {
        return 'Advanced Form notification saved';
    }
}
