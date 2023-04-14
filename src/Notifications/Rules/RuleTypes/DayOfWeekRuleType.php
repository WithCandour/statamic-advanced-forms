<?php

namespace WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleTypes;

use Carbon\Carbon;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\ConditionOperators;
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
    public function conditionOperators(): array
    {
        return [
            ConditionOperators::IS,
            ConditionOperators::IS_NOT
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
                '0' => 'Sunday',
                '1' => 'Monday',
                '2' => 'Tuesday',
                '3' => 'Wednesday',
                '4' => 'Thursday',
                '5' => 'Friday',
                '6' => 'Saturday'
            ],
            'multiple' => true,
        ];
    }

    /**
     * @inheritDoc
     */
    public function passes(
        Submission $submission,
        ConditionOperators $operator,
        mixed $value = null,
        mixed $fields = null
    ): bool {
        $dayOfWeek = Carbon::now()->format('l');

        $value = \is_array($value) ? \array_values($value) : [];

        if ($operator === ConditionOperators::IS) {
            return \in_array($dayOfWeek, $value);
        }

        return !\in_array($dayOfWeek, $value);
    }
}
