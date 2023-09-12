<?php

namespace WithCandour\StatamicAdvancedForms\Models\Stache;

use Statamic\Data\ExistsAsFile;
use Statamic\Facades\Stache;
use Statamic\Support\Traits\FluentlyGetsAndSets;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form as Contract;
use WithCandour\StatamicAdvancedForms\Events\AdvancedFormsFormSaved;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;
use WithCandour\StatamicAdvancedForms\Models\AbstractForm;

class Form extends AbstractForm implements Contract
{
    use ExistsAsFile, FluentlyGetsAndSets;

    protected $id;
    protected $title;
    protected $handle;

    public function id(): string
    {
        return $this->handle();
    }

    /**
     * @inheritDoc
     */
    public function handle(?string $handle = null)
    {
        return $this
            ->fluentlyGetOrSet('handle')
            ->args(func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function title(?string $title = null)
    {
        return $this
            ->fluentlyGetOrSet('title')
            ->args(func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function paginatedFields(?bool $value = null)
    {
        return $this
            ->fluentlyGetOrSet('paginated_fields')
            ->getter(function ($value) {
                return $value ?? false;
            })
            ->args(func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function expiresEntries(?bool $value = false)
    {
        return $this
            ->fluentlyGetOrSet('expires_entries')
            ->getter(function ($value) {
                return $value ?? false;
            })
            ->args(func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function entryLifespan(?int $days = 30)
    {
        return $this
            ->fluentlyGetOrSet('entry_lifespan')
            ->getter(function ($days) {
                return $days;
            })
            ->args(func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function path(): string
    {
        return vsprintf('%s/%s.%s', [
            rtrim(Stache::store('advanced-forms.forms')->directory(), '/'),
            $this->handle(),
            'yaml',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function save(): self
    {
        FormFacade::save($this);

        AdvancedFormsFormSaved::dispatch($this);

        return $this;
    }

    public function fileData()
    {
        $data = [
            'title' => $this->title(),
            'expires_entries' => $this->expiresEntries(),
            'entry_lifespan' => $this->entryLifespan(),
            'paginated_fields' => $this->paginatedFields(),
        ];

        return $data;
    }

}
