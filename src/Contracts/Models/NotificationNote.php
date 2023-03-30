<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

interface NotificationNote extends Note
{
    /**
     * Get the notification for this note.
     *
     * @return Notification
     */
    public function notification(): Notification;

    /**
     * Set the notification for this note.
     *
     * @param Notification $notification
     * @return self
     */
    public function setNotification(Notification $notification): self;
}
