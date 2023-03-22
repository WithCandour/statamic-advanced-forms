<?php

namespace WithCandour\StatamicAdvancedForms\Actions\Feeds;

use Statamic\Actions\Action;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;

class EnableFeedsAction extends Action
{
    public static function title()
    {
        return __('Enable');
    }

    public function authorize($user, $item)
    {
        return $user->can('edit advanced forms feeds');
    }

    public function visibleTo($item)
    {
        return (
            $item instanceof Feed &&
            !$item->enabled()
        );
    }

    public function visibleToBulk($items)
    {
        return \collect($items)
            ->filter(function ($item) {
                return $item instanceof Feed;
            })
            ->some(function ($item) {
                return !$item->enabled();
            });
    }

    public function confirmationText()
    {
        return __('advanced-forms::feeds.enable-confirm');
    }

    public function buttonText()
    {
        return __('advanced-forms::feeds.enable');
    }

    public function run($items, $values)
    {
        $items
            ->filter()
            ->each(function (Feed $feed) {
                $feed
                    ->set('enabled', true)
                    ->save();
            });
    }
}
