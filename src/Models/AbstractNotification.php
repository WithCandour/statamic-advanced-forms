<?php

namespace WithCandour\StatamicAdvancedForms\Models;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification as Contract;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Jobs\SendNotification;

abstract class AbstractNotification implements Contract
{
    /**
     * @inheritDoc
     */
    public function editUrl(): string
    {
        return cp_route(
            'advanced-forms.notifications.edit',
            [
                'advanced_form' => $this->form()->id(),
                'notification' => $this->id(),
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
                'notification' => $this->id(),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function send(Submission $submission): void
    {
        SendNotification::dispatch($this, $submission);
    }
}
