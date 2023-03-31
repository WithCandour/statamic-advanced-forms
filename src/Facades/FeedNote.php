<?php

namespace WithCandour\StatamicAdvancedForms\Facades;

use Illuminate\Support\Facades\Facade;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FeedNotesRepository;

class FeedNote extends Facade
{
    /**
     * @see \WithCandour\StatamicAdvancedForms\Contracts\Repositories\FeedNotesRepository
     */
    protected static function getFacadeAccessor()
    {
        return FeedNotesRepository::class;
    }
}
