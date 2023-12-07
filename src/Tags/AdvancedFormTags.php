<?php

namespace WithCandour\StatamicAdvancedForms\Tags;

use Statamic\Tags\Concerns\RendersForms;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Tags\AdvancedFormBaseTags;

class AdvancedFormTags extends AdvancedFormBaseTags
{
    use RendersForms;

    protected static $handle = 'advanced_form';

    protected ?Form $form = null;

    public $params;

    /**
     * The {{ advanced_form:{form_handle} }} tag.
     */
    public function wildcard()
    {
        $this->params['form'] = $this->method;

        return $this->create();
    }

    /**
     * The {{ advanced_form:create }} tag.
     */
    public function create()
    {
        $form = $this->form();

        $data = $this->getFormSession($this->formHandle());

        $action = $this->params->get('action', $form->actionUrl());
        $method = $this->params->get('method', 'POST');
        $knownParams = ['redirect', 'error_redirect', 'allow_request_redirect', 'csrf', 'files', 'js'];

        $data['csrf_field'] = $this->params->get('csrf', true) ? csrf_field() : null;
        $data['enctype'] = ($this->params->get('files', false) || $form->hasFiles()) ? 'multipart/form-data' : 'application/x-www-form-urlencoded';
        $data['pages'] = $this->getPages();

        $attrs = [];
        $attrs['class'] = 'afb__form';

        $params = [];

        if (! $this->parser) {
            return array_merge([
                'attrs' => $this->formAttrs($action, $method, $knownParams, $attrs),
                'params' => $this->formMetaPrefix($this->formParams($method, $params)),
            ], $data);
        }

        $html = $this->formOpen($action, $method, $knownParams, $attrs);
        $html .= $this->formMetaFields($params);
        $html .= $this->parse($data);
        $html .= $this->formClose();

        return $html;
    }

}
