<?php

namespace WithCandour\StatamicAdvancedForms\Models;

use Illuminate\Support\Arr;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification as Contract;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Facades\NotificationRuleType;
use WithCandour\StatamicAdvancedForms\Jobs\SendNotification;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\ConditionOperators;

abstract class AbstractNotification implements Contract
{
    /**
     * @inheritDoc
     */
    public function editUrl(): string
    {
        return cp_route(
            'advanced-forms.notifications.edit',
            [
                'advanced_form' => $this->form()->id(),
                'notification' => $this->id(),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function deleteUrl(): string
    {
        return cp_route(
            'advanced-forms.notifications.destroy',
            [
                'advanced_form' => $this->form()->id(),
                'notification' => $this->id(),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function shouldSend(Submission $submission): bool
    {
        if (!$this->get('enable_conditional_logic', false)) {
            return true;
        }

        $conditions = \collect($this->get('conditional_logic_conditions', []))
            ->map(function ($data) {

                $enabled = $data['enabled'] ? true : false;
                $condition = ConditionOperators::tryFrom($data['condition']);
                $type = NotificationRuleType::find($data['type']) ?? null;
                $value = $data['value'] ?? null;
                $fields = Arr::except($data, [
                    'enabled',
                    'condition',
                    'type',
                    'value',
                    'id',
                ]);

                return compact(
                    'enabled',
                    'condition',
                    'type',
                    'value',
                    'fields'
                );
            });

        $method = $this->get('conditional_logic_method', 'all') === 'all' ? 'every' : 'some';

        return $conditions->$method(function (array $condition) use ($submission) {
            if (!$condition['type']) {
                return true;
            }

            if (!$condition['enabled']) {
                return false;
            }

            return $condition['type']->passes(
                $submission,
                $condition['condition'],
                $condition['value'],
                $condition['fields']
            );
        });
    }

    /**
     * @inheritDoc
     */
    public function send(Submission $submission): void
    {
        SendNotification::dispatch($this, $submission);
    }
}
