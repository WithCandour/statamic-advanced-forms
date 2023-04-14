<?php

namespace WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleTypes;

use Carbon\Carbon;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\ConditionOperators;
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
    public function conditionOperators(): array
    {
        return [
            ConditionOperators::BEFORE,
            ConditionOperators::AFTER,
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

    /**
     * @inheritDoc
     */
    public function passes(
        Submission $submission,
        ConditionOperators $operator,
        mixed $value = null,
        mixed $fields = null
    ): bool {
        $time = \explode(':', $value);
        $time = \array_map(fn ($part) => intval($part) ?? 0, $time);

        $value = Carbon::now()->setTime($time[0] ?? 0, $time[1] ?? 0);

        if ($operator === ConditionOperators::BEFORE) {
            return Carbon::now()->isBefore($value);
        }

        return Carbon::now()->isAfter($value);
    }
}
