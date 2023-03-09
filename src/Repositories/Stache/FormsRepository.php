<?php

namespace WithCandour\StatamicAdvancedForms\Repositories\Stache;

use Illuminate\Support\Collection;
use Statamic\Stache\Stache;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FormsRepository as Contract;

class FormsRepository implements Contract
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
        $this->store = $stache->store('advanced-forms.forms');
    }

    /**
     * @inheritDoc
     */
    public function make(string $handle): Form
    {
        return app(Form::class)->handle($handle);
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
    public function find(string $id): ?Form
    {
        return $this->store->getItem($id);
    }

    /**
     * @inheritDoc
     */
    public function findByHandle(string $handle): ?Form
    {
        $id = $this->store->index('handle')->items()->flip()->get($handle);
        return $this->find($id);
    }

    /**
     * @inheritDoc
     */
    public function save(Form $form): Form
    {
        $this->store->save($form);
        return $form;
    }

    /**
     * @inheritDoc
     */
    public function delete(Form $form): void
    {
        $this->store->delete($form);
    }
}
