<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Notifications\Rules;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Notifications\Rules\RuleType;

interface RuleTypeRepository
{
    /**
     * Get all rule type classes which are registered with the application.
     *
     * @return Collection
     */
    public function classes(): Collection;

    /**
     * Find a rule type by it's handle.
     *
     * @return RuleType
     * @throws \WithCandour\StatamicAdvancedForms\Exceptions\NotificationRuleTypeNotFoundException
     */
    public function find(string $handle): RuleType;

    /**
     * Get the handles for all registered rule types.
     *
     * @return Collection
     */
    public function handles(): Collection;
}
