<?php

namespace WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleTypes;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\ConditionOperators;
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
                    'max_items' => 1,
                    'form' => $form->id(),
                ]
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function conditionOperators(): array
    {
        return [
            ConditionOperators::IS,
            ConditionOperators::IS_NOT,
            ConditionOperators::CONTAINS,
            ConditionOperators::GREATER_THAN,
            ConditionOperators::LESS_THAN,
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

    /**
     * @inheritDoc
     */
    public function passes(
        Submission $submission,
        ConditionOperators $operator,
        mixed $value = null,
        mixed $fields = null
    ): bool {

        $field = $fields['form_field'] ?? null;

        if (!$field) {
            return false;
        }

        $submissionValue = $submission->values()?->get($fields['form_field']) ?? null;

        if (!$submissionValue) {
            return $operator === ConditionOperators::IS_NOT;
        }

        if ($operator === ConditionOperators::IS) {
            return \is_array($submissionValue) ? \in_array($value, $submissionValue) : $submissionValue === $value;
        } elseif ($operator === ConditionOperators::IS_NOT) {
            return \is_array($submissionValue) ? !\in_array($value, $submissionValue) : $submissionValue !== $value;
        } elseif ($operator === ConditionOperators::CONTAINS) {
            return \is_array($submissionValue) ? \in_array($value, $submissionValue) : \str_contains($submissionValue, $value);
        } elseif ($operator === ConditionOperators::GREATER_THAN) {
            return $submissionValue > $value;
        } elseif ($operator === ConditionOperators::LESS_THAN) {
            return $submissionValue < $value;
        }

        return false;
    }
}
