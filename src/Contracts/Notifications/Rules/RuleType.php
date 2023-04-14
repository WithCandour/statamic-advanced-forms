<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Notifications\Rules;

use WithCandour\StatamicAdvancedForms\Notifications\Rules\ConditionOperators;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;

interface RuleType
{
    /**
     * Get the title for the rule type.
     */
    public static function title(): string;

    /**
     * Get the handle for the rule type.
     *
     * @return string
     */
    public static function handle();

    /**
     * Get the fields for this rule.
     *
     * @param Form $form
     * @return array
     */
    public function fields(Form $form): array;

    /**
     * Get the condition operators which may be applied for this rule.
     *
     * @return ConditionOperators[]
     */
    public function conditionOperators(): array;

    /**
     * Get the value field settings.
     *
     * @return array
     */
    public function valueFieldSettings(): array;

    /**
     * Determine whether this rule passes for a given submission and operator.
     *
     * @param Submission $submission
     * @param ConditionOperators $operator
     * @param mixed $value
     * @param mixed $fields
     * @return bool
     */
    public function passes(
        Submission $submission,
        ConditionOperators $operator,
        mixed $value = null,
        mixed $fields = null
    ): bool;
}
