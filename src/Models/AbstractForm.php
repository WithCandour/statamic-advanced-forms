<?php

namespace WithCandour\StatamicAdvancedForms\Models;

use Statamic\Facades\Blueprint as BlueprintFacade;
use Statamic\Fields\Blueprint;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form as Contract;
use WithCandour\StatamicAdvancedForms\Facades\Notification;

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
    public function blueprint(): Blueprint
    {
        $blueprint = BlueprintFacade::find('advanced-forms.' . $this->handle()) ??
            Blueprint::makeFromFields([])->setHandle($this->handle())->setNamespace('advanced-forms');

        return $blueprint;
    }

    /**
     * @inheritDoc
     */
    public function notifications(): array
    {
        return Notification::findByForm($this)
            ->all();
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
