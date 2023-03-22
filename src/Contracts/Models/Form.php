<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

use Statamic\Fields\Blueprint;

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
     * Get the form fields blueprint.
     *
     * @return \Statamic\Fields\Blueprint
     */
    public function blueprint(): Blueprint;

    /**
     * Get a list of notifications for this form.
     *
     * @return \WithCandour\StatamicAdvancedForms\Contracts\Models\Notification[]
     */
    public function notifications(): array;

    /**
     * Get a list of feeds for this form.
     *
     * @return \WithCandour\StatamicAdvancedForms\Contracts\Models\Feed[]
     */
    public function feeds(): array;

    /**
     * Get or set whether the fields are paginated for this form.
     *
     * @param bool|null $value
     * @return bool|void
     */
    public function paginatedFields(?bool $value = null);

    /**
     * Get the show url of the form.
     *
     * @return string
     */
    public function showUrl(): string;

    /**
     * Get the delete url of the form.
     *
     * @return string
     */
    public function deleteUrl(): string;

    /**
     * Save the form.
     *
     * @return void
     */
    public function save(): self;
}
