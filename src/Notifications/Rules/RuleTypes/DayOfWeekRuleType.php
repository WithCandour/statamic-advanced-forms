<?php

namespace WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleTypes;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\Conditions;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleType;

class DayOfWeekRuleType extends RuleType
{
    protected static $title = 'Current day';

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
            Conditions::IS,
            Conditions::IS_NOT
        ];
    }

    /**
     * @inheritDoc
     */
    public function valueFieldSettings(): array
    {
        return [
            'display' => 'Day(s)',
            'type' => 'select',
            'options' => [
                0 => 'Sunday',
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday'
            ],
            'multiple' => true,
        ];
    }
}
