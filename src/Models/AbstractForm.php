<?php

namespace WithCandour\StatamicAdvancedForms\Models;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Form as Contract;

abstract class AbstractForm implements Contract
{
    /**
     * @inheritDoc
     */
    public function editUrl(): string
    {
        return cp_route('advanced-forms.edit', $this->handle());
    }

    /**
     * @inheritDoc
     */
    public function deleteUrl(): string
    {
        return cp_route('advanced-forms.destroy', $this->handle());
    }
}
