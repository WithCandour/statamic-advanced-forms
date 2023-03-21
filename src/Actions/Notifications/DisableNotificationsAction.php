<?php

namespace WithCandour\StatamicAdvancedForms\Actions\Notifications;

use Statamic\Actions\Action;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;

class DisableNotificationsAction extends Action
{
    public static function title()
    {
        return __('Disable');
    }

    public function authorize($user, $item)
    {
        return $user->can('edit advanced forms notifications');
    }

    public function visibleTo($item)
    {
        return (
            $item instanceof Notification &&
            $item->enabled()
        );
    }

    public function visibleToBulk($items)
    {
        return \collect($items)
            ->filter(function ($item) {
                return $item instanceof Notification;
            })
            ->some(function ($item) {
                return $item->enabled();
            });
    }

    public function confirmationText()
    {
        return __('advanced-forms::notifications.disable-confirm');
    }

    public function buttonText()
    {
        return __('advanced-forms::notifications.disable');
    }

    public function run($items, $values)
    {
        $items
            ->filter()
            ->each(function (Notification $notification) {
                $notification
                    ->set('enabled', false)
                    ->save();
            });
    }
}
