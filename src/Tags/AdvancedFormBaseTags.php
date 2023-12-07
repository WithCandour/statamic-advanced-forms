<?php

namespace WithCandour\StatamicAdvancedForms\Tags;

use Exception;
use Statamic\Fields\Field;
use Statamic\Fields\Section;
use Statamic\Tags\Tags;
use WithCandour\StatamicAdvancedForms\Exceptions\AdvancedFormNotFoundException;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Http\Controllers\Actions\FormController;

class AdvancedFormBaseTags extends Tags
{

    protected ?Form $form = null;

    public $params;

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
     * Get the form handle for this tag.
     *
     * @return string|null
     */
    protected function formHandle(): ?string
    {
        return $this->params->get('form');
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

        return $blueprint->tabs()->first()->sections()
            ->map(function (Section $section) {
                return [
                    'title' => $section->display(),
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
}
