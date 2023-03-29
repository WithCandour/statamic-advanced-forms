<?php

namespace WithCandour\StatamicAdvancedForms\Facades;

use Illuminate\Support\Facades\Facade;
use WithCandour\StatamicAdvancedForms\Contracts\Notifications\Rules\RuleTypeRepository;

class NotificationRuleType extends Facade
{
    /**
     * @see \WithCandour\StatamicAdvancedForms\Contracts\Notifications\Rules\RuleTypeRepository
     */
    protected static function getFacadeAccessor()
    {
        return RuleTypeRepository::class;
    }
}
