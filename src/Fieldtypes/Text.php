<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fieldtypes\Text as CoreText;

class Text extends CoreText
{
    public function configFieldItems(): array
    {
        return [
            'allow_url_prefill' => [
                'display' => 'Allow URL Prefill',
                'instructions' => 'When active, the field will pull the value from a GET parameter in a URL of the same name as the field handle.',
                'type' => 'toggle',
                'default' => false,
                'width' => 200
            ]
        ];
    }
    
    public function view()
    {
        $default = 'statamic::forms.fields.'.$this->handle();

        return view()->exists($default)
            ? $default
            : 'statamic::forms.fields.default';
    }
}
