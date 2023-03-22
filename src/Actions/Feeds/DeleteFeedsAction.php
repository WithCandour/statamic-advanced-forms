<?php

namespace WithCandour\StatamicAdvancedForms\Actions\Feeds;

use Statamic\Actions\Action;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;
use WithCandour\StatamicAdvancedForms\Facades\Feed as FeedFacade;

class DeleteFeedsAction extends Action
{
    protected $dangerous = true;

    public static function title()
    {
        return __('Delete');
    }

    public function authorize($user, $item)
    {
        return $user->can('delete advanced forms feeds');
    }

    public function visibleTo($item)
    {
        return $item instanceof Feed;
    }

    public function visibleToBulk($items)
    {
        return \collect($items)
            ->every(function ($item) {
                return $item instanceof Feed;
            });
    }

    public function confirmationText()
    {
        return __('advanced-forms::feeds.delete-confirm');
    }

    public function buttonText()
    {
        return __('advanced-forms::feeds.delete');
    }

    public function run($items, $values)
    {
        $items
            ->filter()
            ->each(function (Feed $feed) {
                FeedFacade::delete($feed);
            });
    }
}
