<?php

namespace WithCandour\StatamicAdvancedForms\Facades;

use Illuminate\Support\Facades\Facade;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\NotificationNotesRepository;

class NotificationNnote extends Facade
{
    /**
     * @see \WithCandour\StatamicAdvancedForms\Contracts\Repositories\NotificationNotesRepository
     */
    protected static function getFacadeAccessor()
    {
        return NotificationNotesRepository::class;
    }
}
