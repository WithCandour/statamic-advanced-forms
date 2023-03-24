<?php

namespace WithCandour\StatamicAdvancedForms\Models\Stache;

use Statamic\Data\ContainsData;
use Statamic\Data\ExistsAsFile;
use Statamic\Facades\Stache;
use Statamic\Support\Traits\FluentlyGetsAndSets;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification as Contract;
use WithCandour\StatamicAdvancedForms\Events\AdvancedFormsNotificationSaved;
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
    public function title()
    {
        return $this->get('title', $this->id());
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
    public function enabled(): bool
    {
        return $this->get('enabled', false);
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

        AdvancedFormsNotificationSaved::dispatch($this);

        return $this;
    }

    public function fileData()
    {
        $default = [
            'form' => $this->form()->id(),
        ];

        $data = \collect($this->data())->all();

        return array_merge($default, $data);
    }

}
