<?php

namespace WithCandour\StatamicAdvancedForms\Notifications\Rules;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Notifications\Rules\RuleTypeRepository as Contract;
use WithCandour\StatamicAdvancedForms\Contracts\Notifications\Rules\RuleType;
use WithCandour\StatamicAdvancedForms\Exceptions\NotificationRuleTypeNotFoundException;

class RuleTypeRepository implements Contract
{
    /**
     * @inheritDoc
     */
    public function classes(): Collection
    {
        return app('statamic.advanced_forms_notification_rule_types');
    }

    /**
     * @inheritDoc
     */
    public function find(string $handle): RuleType
    {
        $ruleTypes = $this->classes();

        if (!$ruleTypes->has($handle)) {
            throw new NotificationRuleTypeNotFoundException($handle);
        }

        return app($ruleTypes->get($handle));
    }

    /**
     * @inheritDoc
     */
    public function handles(): Collection
    {
        return $this->classes()->map(function ($ruleType) {
            return $ruleType::handle();
        });
    }
}
