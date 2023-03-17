<?php

namespace WithCandour\StatamicAdvancedForms\Repositories\Stache;

use Illuminate\Support\Collection;
use Statamic\Stache\Stache;
use Statamic\Support\Str;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\NotificationsRepository as Contract;

class NotificationsRepository implements Contract
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
        $this->store = $stache->store('advanced-forms.notifications');
    }

    /**
     * @inheritDoc
     */
    public function make(): Notification
    {
        return app(Notification::class);
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
    public function find(string $id): ?Notification
    {
        ray($this->store->stores());
        return null;
        // return $this->store->getItem(Str::ensureLeft($id, 'notifications_'));
    }

    /**
     * @inheritDoc
     */
    public function findByForm(Form $form): Collection
    {
        $ids = $this->store->index('form')->items()->flip()->get($form->id());
        return \collect($ids)
            ->map(fn ($id) => $this->find($id));
    }

    /**
     * @inheritDoc
     */
    public function save(Notification $notification): Notification
    {
        if (!$notification->id()) {
            $notification->id($this->stache->generateId());
        }

        $this->store->store($notification->form()->id())->save($notification);
        return $notification;
    }

    /**
     * @inheritDoc
     */
    public function delete(Notification $notification): void
    {
        $this->store->delete($notification);
    }
}
