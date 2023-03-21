<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Repositories;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;

interface NotificationsRepository
{
    /**
     * Create a new notification.
     */
    public function make(?string $id = null): Notification;

    /**
     * Return all notifications from the filesystem.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection;

    /**
     * Find a notification by its ID.
     *
     * @param string $id
     * @return Notification|null
     */
    public function find(string $id): ?Notification;

    /**
     * Find all notifications for a given form.
     *
     * @param Form
     * @return Collection
     */
    public function findByForm(Form $form): Collection;

    /**
     * Save a notification.
     *
     * @param Notification $notification
     * @return Notification
     */
    public function save(Notification $notification): Notification;

    /**
     * Delete a notification.
     *
     * @param Notification $notification
     * @return void
     */
    public function delete(Notification $notification): void;
}
