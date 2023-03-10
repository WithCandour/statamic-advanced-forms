<?php

namespace WithCandour\StatamicAdvancedForms\Models;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Form as Contract;

abstract class AbstractForm implements Contract
{
    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * @inheritDoc
     */
    public function showUrl(): string
    {
        return cp_route('advanced-forms.show', $this->id());
    }

    /**
     * @inheritDoc
     */
    public function deleteUrl(): string
    {
        return cp_route('advanced-forms.destroy', $this->id());
    }
}
