<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Illuminate\Support\Collection;
use Statamic\CP\Column;
use Statamic\Fields\Field;
use Statamic\Fieldtypes\Relationship;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;

class AdvancedFormsFieldSelect extends Relationship
{
    protected $selectable = false;
    protected $statusIcons = false;
    protected $canCreate = false;
    protected $canEdit = false;
    protected $canSearch = false;

    /**
     * @inheritDoc
     */
    protected function configFieldItems(): array
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
            'form' => [
                'display' => 'Form',
                'instructions' => 'Select a form to pull the fields from',
                'max_items' => 1,
                'type' => 'advanced_forms',
                'validate' => 'required',
            ],
            'input_type_requirement' => [
                'display' => 'Mode Requirement',
                'instructions' => 'Comma separated list of text field modes, the field must be one of these to be listed',
                'type' => 'select',
                'clearable' => true,
                'multiple' => true,
                'width' => 50,
                'options' => [
                    'color',
                    'date',
                    'email',
                    'hidden',
                    'month',
                    'number',
                    'password',
                    'tel',
                    'text',
                    'time',
                    'url',
                    'week',
                ],
            ],
        ];
    }

    protected function blueprintFields(): ?Collection
    {
        $formId = $this->config('form');

        if (!$form = FormFacade::find($formId)) {
            return [];
        }

        if (!$blueprint = $form->blueprint()) {
            return null;
        }

        return $blueprint
            ->fields()
            ->all()
            ->filter(function (Field $field) {
                if ($inputTypeRequirement = $this->config('input_type_requirement')) {
                    $fieldConfig = \collect($field->config());

                    if ($fieldInputType = $fieldConfig->get('input_type')) {
                        return \in_array($fieldInputType, $inputTypeRequirement);
                    }

                    return false;
                }

                return true;
            });
    }

    public function getIndexItems($request)
    {
        if (empty($this->blueprintFields())) {
            return [];
        }

        return $this->blueprintFields()
            ->map(function (Field $field) {
                return [
                    'id' => $field->handle(),
                    'title' => $field->display(),
                ];
            })
            ->all();
    }

    public function toItemArray($handle)
    {
        $field = $this->blueprintFields();

        if ($field = $this->blueprintFields()->get($handle)) {
            return [
                'id' => $field->handle(),
                'title' => $field->display(),
            ];
        }

        return $this->invalidItemArray($handle);
    }

    protected function getColumns()
    {
        return [
            Column::make('title'),
            Column::make('id')->label(__('Handle')),
        ];
    }
}
