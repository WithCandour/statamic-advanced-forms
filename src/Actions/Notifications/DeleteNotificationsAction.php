<?php

namespace WithCandour\StatamicAdvancedForms\Actions\Notifications;

use Statamic\Actions\Action;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;
use WithCandour\StatamicAdvancedForms\Facades\Notification as NotificationFacade;

class DeleteNotificationsAction extends Action
{
    protected $dangerous = true;

    public static function title()
    {
        return __('Delete');
    }

    public function authorize($user, $item)
    {
        return $user->can('delete advanced forms notifications');
    }

    public function visibleTo($item)
    {
        return $item instanceof Notification;
    }

    public function visibleToBulk($items)
    {
        return \collect($items)
            ->all(function ($item) {
                return $item instanceof Notification;
            });
    }

    public function confirmationText()
    {
        return __('advanced-forms::notifications.delete-confirm');
    }

    public function buttonText()
    {
        return __('advanced-forms::notifications.delete');
    }

    public function run($items, $values)
    {
        $items
            ->filter()
            ->each(function (Notification $notification) {
                NotificationFacade::delete($notification);
            });
    }
}
