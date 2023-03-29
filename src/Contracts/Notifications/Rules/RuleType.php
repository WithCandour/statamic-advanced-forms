<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Notifications\Rules;

use WithCandour\StatamicAdvancedForms\Notifications\Rules\Conditions;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;

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
     * Get the conditions which may be applied for this rule.
     *
     * @return Conditions[]
     */
    public function conditions(): array;

    /**
     * Get the value field settings.
     *
     * @return array
     */
    public function valueFieldSettings(): array;
}
