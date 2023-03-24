<?php

namespace WithCandour\StatamicAdvancedForms\Models;

use Statamic\Facades\Blueprint;
use Statamic\Fields\Blueprint as StatamicBlueprint;
use Statamic\Fields\Section;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed as Contract;

abstract class AbstractFeed implements Contract
{
    /**
     * @inheritDoc
     */
    public function blueprint(): StatamicBlueprint
    {
        $defaultSections = \collect([
            'name' => [
                'display' => __('Name'),
                'fields' => [
                    'title' => [
                        'display' => __('Title'),
                        'type' => 'text',
                        'validate' => 'required',
                    ],
                    'enabled' => [
                        'display' => __('advanced-forms::feeds.enabled'),
                        'type' => 'toggle',
                        'instructions' => __('advanced-forms::feeds.enabled_instruct'),
                        'default' => true,
                    ]
                ],
            ],
        ]);

        $typeBlueprintSections = \collect(
            $this->type()->configSections($this->form()) ?? []
        );

        $sections = $defaultSections->merge($typeBlueprintSections);

        return Blueprint::makeFromSections($sections);
    }

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
