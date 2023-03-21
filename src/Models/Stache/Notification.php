<?php

namespace WithCandour\StatamicAdvancedForms\Models\Stache;

use Statamic\Data\ContainsData;
use Statamic\Data\ExistsAsFile;
use Statamic\Facades\Stache;
use Statamic\Support\Traits\FluentlyGetsAndSets;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification as Contract;
use WithCandour\StatamicAdvancedForms\Facades\Notification as NotificationFacade;
use WithCandour\StatamicAdvancedForms\Models\AbstractNotification;

class Notification extends AbstractNotification implements Contract
{
    use ExistsAsFile, FluentlyGetsAndSets, ContainsData;

    protected $id;
    protected $title;
    protected $form;

    public function id(?string $id = null)
    {
        return $this
            ->fluentlyGetOrSet('id')
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
    public function form(?Form $form = null)
    {
        return $this
            ->fluentlyGetOrSet('form')
            ->args(func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function path(): string
    {
        return vsprintf('%s/%s.%s', [
            rtrim(Stache::store('advanced-forms.notifications')->directory(), '/'),
            $this->id(),
            'yaml',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function save(): self
    {
        NotificationFacade::save($this);

        return $this;
    }

    public function fileData()
    {
        $data = [
            'title' => $this->title(),
            'form' => $this->form()->id(),
        ];

        return array_merge($data, $this->data()->all());
    }

}
