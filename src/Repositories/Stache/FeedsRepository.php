<?php

namespace WithCandour\StatamicAdvancedForms\Repositories\Stache;

use Illuminate\Support\Collection;
use Statamic\Stache\Stache;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FeedsRepository as Contract;

class FeedsRepository implements Contract
{
    /**
     * @var Stache
     */
    protected Stache $stache;

    protected $store;

    /**
     * @param Statamic\Stache\Stache $stache
     */
    public function __construct(Stache $stache)
    {
        $this->stache = $stache;
        $this->store = $stache->store('advanced-forms.feeds');
    }

    /**
     * @inheritDoc
     */
    public function make(?string $id = null): Feed
    {
        $feed = app(Feed::class);

        if (!empty($id)) {
            $feed->id($id);
        }

        return $feed;
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        $keys = $this->store->paths()->keys();
        return \collect($this->store->getItems($keys));
    }

    /**
     * @inheritDoc
     */
    public function find(string $id): ?Feed
    {
        return $this->store->getItem($id);
    }

    /**
     * @inheritDoc
     */
    public function findByForm(Form $form): Collection
    {
        return $this->store->index('form')->items()
            ->filter(fn (Form $stacheForm) => $stacheForm->id() === $form->id())
            ->keys()
            ->map(fn ($id) => $this->find($id));
    }

    /**
     * @inheritDoc
     */
    public function save(Feed $feed): Feed
    {
        if (!$feed->id()) {
            $feed->id($this->stache->generateId());
        }

        $this->store->save($feed);
        return $feed;
    }

    /**
     * @inheritDoc
     */
    public function delete(Feed $feed): void
    {
        $this->store->delete($feed);
    }
}
