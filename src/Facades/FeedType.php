<?php

namespace WithCandour\StatamicAdvancedForms\Facades;

use Illuminate\Support\Facades\Facade;
use WithCandour\StatamicAdvancedForms\Contracts\Feeds\FeedTypeRepository;

class FeedType extends Facade
{
    /**
     * @see \WithCandour\StatamicAdvancedForms\Contracts\Feeds\FeedTypeRepository
     */
    protected static function getFacadeAccessor()
    {
        return FeedTypeRepository::class;
    }
}
