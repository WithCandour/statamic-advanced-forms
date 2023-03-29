<?php

namespace WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleTypes;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\Conditions;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleType;

class FieldValueRuleType extends RuleType
{
    protected static $title = 'Field value';

    /**
     * @inheritDoc
     */
    public function fields(Form $form): array
    {
        return [
            'form_field' => [
                'handle' => 'form_field',
                'field' => [
                    'display' => __('Field'),
                    'type' => 'advanced_forms_field_select',
                    'form' => $form->id(),
                ]
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function conditions(): array
    {
        return [
            Conditions::IS,
            Conditions::IS_NOT,
            Conditions::CONTAINS,
            Conditions::GREATER_THAN,
            Conditions::LESS_THAN,
        ];
    }

    /**
     * @inheritDoc
     */
    public function valueFieldSettings(): array
    {
        return [
            'display' => __('Value'),
            'type' => 'text'
        ];
    }
}
