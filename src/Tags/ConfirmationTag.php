<?php

namespace WithCandour\StatamicAdvancedForms\Tags;

use Exception;
use Statamic\Fields\Field;
use Statamic\Fields\Section;
use Statamic\Tags\Concerns\RendersForms;
use Statamic\Tags\Tags;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Http\Controllers\Actions\FormController;

class ConfirmationTag extends Tags
{
    protected static $handle = 'confirmation';

    public $params;

    /**
     * The {{ confirmation }} tag.
     */
    public function index()
    {
        return $this->context->get('title');

        $data = $this->getFormSession($this->formHandle());

        if (!empty($data['errors'])) {
            return $data['errors'];
        }

        if (!empty($data['success'])) {
            return $data['success'];
        }

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
