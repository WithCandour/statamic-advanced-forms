<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP\Actions;

use Statamic\Http\Controllers\CP\Assets\ActionController;
use WithCandour\StatamicAdvancedForms\Facades\Notification;

class NotificationActionController extends ActionController
{
    protected function getSelectedItems($items, $context)
    {
        return $items->map(function ($item) {
            return Notification::find($item);
        });
    }
}
