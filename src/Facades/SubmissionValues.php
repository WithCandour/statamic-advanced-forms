<?php

namespace WithCandour\StatamicAdvancedForms\Facades;

use Illuminate\Support\Facades\Facade;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\SubmissionValuesRepository;

class SubmissionValues extends Facade
{
    /**
     * @see \WithCandour\StatamicAdvancedForms\Contracts\Repositories\SubmissionValuesRepository
     */
    protected static function getFacadeAccessor()
    {
        return SubmissionValuesRepository::class;
    }
}
