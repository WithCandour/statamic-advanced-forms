<?php

namespace WithCandour\StatamicAdvancedForms\Models\Stache;

use Statamic\Data\ExistsAsFile;
use Statamic\Facades\Stache;
use Statamic\Support\Traits\FluentlyGetsAndSets;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form as Contract;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;
use WithCandour\StatamicAdvancedForms\Models\AbstractForm;

class Form extends AbstractForm implements Contract
{
    use ExistsAsFile, FluentlyGetsAndSets;

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
        return $this->fluentlyGetOrSet('handle')->args(func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function title(?string $title = null)
    {
        return $this
            ->fluentlyGetOrSet('title')
            ->getter(function ($title) {
                return $title ?? ucfirst($this->handle);
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
        $isNew = \is_null(FormFacade::find($this->id()));

        FormFacade::save($this);

        return $this;
    }

    public function fileData()
    {
        $data = [
            'title' => $this->title(),
        ];

        return $data;
    }

}
