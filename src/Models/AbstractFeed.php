<?php

namespace WithCandour\StatamicAdvancedForms\Models;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed as Contract;

abstract class AbstractFeed implements Contract
{
    /**
     * @inheritDoc
     */
    public function editUrl(): string
    {
        return cp_route(
            'advanced-forms.feeds.edit',
            [
                'advanced_form' => $this->form()->id(),
                'feed' => $this->id(),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function deleteUrl(): string
    {
        return cp_route(
            'advanced-forms.feeds.destroy',
            [
                'advanced_form' => $this->form()->id(),
                'feed' => $this->id(),
            ]
        );
    }
}
