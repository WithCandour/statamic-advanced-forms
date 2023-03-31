<?php

namespace WithCandour\StatamicAdvancedForms\Tags;

use Exception;
use Statamic\Fields\Field;
use Statamic\Fields\Section;
use Statamic\Tags\Concerns\RendersForms;
use Statamic\Tags\Tags;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Exceptions\AdvancedFormNotFoundException;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;
use WithCandour\StatamicAdvancedForms\Http\Controllers\Actions\FormController;

class AdvancedFormTags extends Tags
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

        $data['action_url'] = $this->params->get('action', $form->actionUrl());
        $data['method'] = $this->params->get('method', 'POST');
        $data['csrf_field'] = $this->params->get('csrf', true) ? csrf_field() : null;
        $data['enctype'] = ($this->params->get('files', false) || $form->hasFiles()) ? 'multipart/form-data' : 'application/x-www-form-urlencoded';
        $data['pages'] = $this->getPages();

        return $this->parse($data);
    }

    /**
     * Get the form for this tag.
     *
     * @return Form
     */
    protected function form(): Form
    {
        if (empty($this->form)) {
            $handle = $this->formHandle();

            if (!$handle) {
                throw new Exception('Advanced form tag rendered without a form.');
            }

            $form = FormFacade::find($handle);

            if (!$form) {
                throw new AdvancedFormNotFoundException($handle);
            }

            $this->form = $form;
        }

        return $this->form;
    }

    /**
     * Get the form handle for this tag.
     *
     * @return string|null
     */
    protected function formHandle(): ?string
    {
        return $this->params->get('form');
    }

    /**
     * Get all pages for this form.
     *
     * @return array
     */
    protected function getPages(): array
    {
        $blueprint = $this->form()?->blueprint();

        if (empty($blueprint)) {
            return [];
        }

        return $blueprint->sections()
            ->map(function (Section $section) {
                return [
                    'title' => $section->display(),
                    'handle' => $section->handle(),
                    'fields' => $section
                        ->fields()
                        ->all()
                        ->map(function (Field $field) {
                            return $this->getRenderableField($field, $this->sessionHandle());
                        })
                        ->values()
                        ->toArray()
                ];
            })
            ->values()
            ->toArray();
    }

    /**
     * Get the session handle.
     *
     * @return string
     */
    protected function sessionHandle(): string
    {
        $prefix = FormController::FORM_SESSION_PREFIX ?? 'advanced_forms.';
        return $prefix .= $this->form()?->handle();
    }

    /**
     * Get value from form session.
     *
     * @param string $formHandle
     * @param string $key
     */
    protected function getFromFormSession($key)
    {
        return session()->get($this->sessionHandle() . ".$key");
    }

    /**
     * Get form session error/success output.
     *
     * @param string $formHandle
     * @return array
     */
    protected function getFormSession(string $formHandle): array
    {
        $data = [];

        $errors = optional(session()->get('errors'))->getBag($this->sessionHandle());

        $data['errors'] = $errors ? $errors->all() : [];
        $data['error'] = $errors ? $this->getFirstErrorForEachField($errors) : [];
        $data['success'] = $this->getFromFormSession('success');

        return $data;
    }

    /**
     * Get first error for each field.
     *
     * @param  \Illuminate\Support\MessageBag  $messageBag
     * @return array
     */
    protected function getFirstErrorForEachField($messageBag)
    {
        return collect($messageBag->messages())
            ->map(function ($errors, $field) {
                return $errors[0];
            })
            ->all();
    }
}
