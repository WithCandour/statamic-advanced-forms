<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

interface Form
{
    /**
     * Get the form ID
     *
     * @return string
     */
    public function id(): string;

    /**
     * Get or set the form handle.
     *
     * @param string|null $handle
     * @return string|void
     */
    public function handle(?string $handle = null);

    /**
     * Get or set the form title.
     *
     * @param string|null $handle
     * @return string|void
     */
    public function title(?string $title = null);

    /**
     * Save the form.
     *
     * @return void
     */
    public function save(): self;

    /**
     * Get the edit url of the form.
     *
     * @return string
     */
    public function editUrl(): string;

    /**
     * Get the delete url of the form.
     *
     * @return string
     */
    public function deleteUrl(): string;
}
