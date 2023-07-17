<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fields\Fieldtype;

class SectionDivider extends Fieldtype
{
    protected $categories = ['special'];

    protected $canCreate = false;

    public function configFieldItems(): array
    {
        return [
            'section_divider_heading_title' => [
                'display' => 'Section Divider Heading Title',
                'type' => 'text',
                'default' => '',
                'width' => 100
            ],
            'section_divider_heading_content' => [
                'display' => 'Section Divider Heading Content',
                'type' => 'textarea',
                'default' => '',
                'width' => 100
            ],
        ];
    }

    public function preProcess($data)
    {
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function process($data)
    {
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function selectable() : bool
    {
        return 0;
    }

    public function selectableInForms() : bool
    {
        return 1;
    }


    /**
     * @inheritDoc
     */
    public function view()
    {
        $default = 'statamic-advanced-forms::fieldtypes.section_divider';

        return view()->exists($default)
            ? $default
            : 'statamic::forms.fields.default';
    }
}
