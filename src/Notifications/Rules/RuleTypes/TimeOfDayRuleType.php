<?php

namespace WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleTypes;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\Conditions;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleType;

class TimeOfDayRuleType extends RuleType
{
    protected static $title = 'Current time';

     /**
     * @inheritDoc
     */
    public function fields(Form $form): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function conditions(): array
    {
        return [
            Conditions::BEFORE,
            Conditions::AFTER,
        ];
    }

    /**
     * @inheritDoc
     */
    public function valueFieldSettings(): array
    {
        return [
            'display' => __('Time'),
            'type' => 'time'
        ];
    }
}
