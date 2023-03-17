<?php

namespace WithCandour\StatamicAdvancedForms\Models;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification as Contract;

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
}
