<?php

namespace WithCandour\StatamicAdvancedForms\Feeds;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Feeds\FeedTypeRepository as Contract;
use WithCandour\StatamicAdvancedForms\Contracts\Feeds\FeedType;
use WithCandour\StatamicAdvancedForms\Exceptions\FeedTypeNotFoundException;

class FeedTypeRepository implements Contract
{
    /**
     * @inheritDoc
     */
    public function classes(): Collection
    {
        return app('statamic.advanced_forms_feed_types');
    }

    /**
     * @inheritDoc
     */
    public function find(string $handle): FeedType
    {
        $feedTypes = $this->classes();

        if (!$feedTypes->has($handle)) {
            throw new FeedTypeNotFoundException($handle);
        }

        return app($feedTypes->get($handle));
    }

    /**
     * @inheritDoc
     */
    public function handles(): Collection
    {
        return $this->classes()->map(function (FeedType $feedType) {
            return $feedType::handle();
        });
    }

    /**
     * @inheritDoc
     */
    public function selectable(): Collection
    {
        return $this->classes()->filter(function (FeedType $feedType) {
            return $feedType::selectable();
        });
    }
}
