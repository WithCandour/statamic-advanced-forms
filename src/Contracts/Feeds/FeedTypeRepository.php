<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Feeds;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Feeds\FeedType;

interface FeedTypeRepository
{
    /**
     * Get all feed type classes which are registered with the application.
     *
     * @return Collection
     */
    public function classes(): Collection;

    /**
     * Find a feed type by it's handle.
     *
     * @return FeedType
     * @throws \WithCandour\StatamicAdvancedForms\Exceptions\FeedTypeNotFoundException
     */
    public function find(string $handle): FeedType;

    /**
     * Get the handles for all registered feed types.
     *
     * @return Collection
     */
    public function handles(): Collection;

    /**
     * Get all feed types which are selectable.
     *
     * @return Collection
     */
    public function selectable(): Collection;
}
