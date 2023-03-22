<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Repositories;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;

interface FeedsRepository
{
    /**
     * Create a new feed.
     */
    public function make(?string $id = null): Feed;

    /**
     * Return all feeds from the filesystem.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection;

    /**
     * Find a feed by its ID.
     *
     * @param string $id
     * @return Feed|null
     */
    public function find(string $id): ?Feed;

    /**
     * Find all feeds for a given form.
     *
     * @param Form
     * @return Collection
     */
    public function findByForm(Form $form): Collection;

    /**
     * Save a feed.
     *
     * @param Feed $feed
     * @return Feed
     */
    public function save(Feed $feed): Feed;

    /**
     * Delete a feed.
     *
     * @param Feed $feed
     * @return void
     */
    public function delete(Feed $feed): void;
}
