<?php

namespace WithCandour\StatamicAdvancedForms\Facades;

use Illuminate\Support\Facades\Facade;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\SubmissionsRepository;

class Submission extends Facade
{
    /**
     * @see \WithCandour\StatamicAdvancedForms\Contracts\Repositories\SubmissionsRepository
     */
    protected static function getFacadeAccessor()
    {
        return SubmissionsRepository::class;
    }
}
