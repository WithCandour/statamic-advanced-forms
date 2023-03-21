<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Illuminate\Support\Collection;
use Statamic\CP\Column;
use Statamic\Fieldtypes\Relationship;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;

class AdvancedForms extends Relationship
{
    protected $statusIcons = false;
    protected $canCreate = false;
    protected $canEdit = false;
    protected $canSearch = false;

    public function configFieldItems(): array
    {
        return [
            'max_items' => [
                'type' => 'integer',
                'display' => __('Max Items'),
                'default' => 1,
                'instructions' => __('statamic::fieldtypes.form.config.max_items'),
                'min' => 1,
                'width' => 50,
            ],
        ];
    }

    public function fieldsetContents()
    {
        return [];
    }

    public function getIndexItems($request)
    {
        return FormFacade::all()
            ->map(function (Form $form) {
                return [
                    'id' => $form->id(),
                    'title' => $form->title()
                ];
            });
    }

    public function toItemArray($id)
    {
        if ($form = FormFacade::find($id)) {
            return [
                'id' => $form->id(),
                'title' => $form->title(),
            ];
        }

        return $this->invalidItemArray($id);
    }

    protected function getColumns()
    {
        return [
            Column::make('title'),
        ];
    }
}
