<?php

namespace WithCandour\StatamicAdvancedForms\Models;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Form as Contract;

abstract class AbstractForm implements Contract
{
    /**
     * @inheritDoc
     */
    public function showUrl(): string
    {
        return cp_route('advanced-forms.show', $this->handle());
    }

    /**
     * @inheritDoc
     */
    public function deleteUrl(): string
    {
        return cp_route('advanced-forms.destroy', $this->handle());
    }
}
