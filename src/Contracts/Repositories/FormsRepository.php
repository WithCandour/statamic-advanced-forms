<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Repositories;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;

interface FormsRepository
{
    /**
     * Create a new form.
     *
     * @param string $handle
     */
    public function make(string $handle): Form;

    /**
     * Return all forms from the filesystem.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection;

    /**
     * Find a form by its ID.
     *
     * @param string $id
     * @return \WithCandour\StatamicAdvancedForms\Contracts\Models\Form|null
     */
    public function find(string $id): ?Form;

    /**
     * Find a form by its handle.
     *
     * @param string $handle
     * @return \WithCandour\StatamicAdvancedForms\Contracts\Models\Form|null
     */
    public function findByHandle(string $handle): ?Form;

    /**
     * Save a form.
     *
     * @param Form $form
     * @return Form
     */
    public function save(Form $form): Form;

    /**
     * Delete a form.
     *
     * @param Form $form
     * @return void
     */
    public function delete(Form $form): void;
}
