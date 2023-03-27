<?php

namespace WithCandour\StatamicAdvancedForms\Models\Stache;

use Statamic\Data\ContainsData;
use Statamic\Data\ExistsAsFile;
use Statamic\Facades\Stache;
use Statamic\Support\Traits\FluentlyGetsAndSets;
use WithCandour\StatamicAdvancedForms\Contracts\Feeds\FeedType;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed as Contract;
use WithCandour\StatamicAdvancedForms\Events\AdvancedFormsFeedSaved;
use WithCandour\StatamicAdvancedForms\Facades\Feed as FeedFacade;
use WithCandour\StatamicAdvancedForms\Models\AbstractFeed;

class Feed extends AbstractFeed implements Contract
{
    use ExistsAsFile, FluentlyGetsAndSets, ContainsData;

    protected $id;
    protected $title;
    protected $form;
    protected $type;

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
    public function type(?FeedType $type = null)
    {
        return $this
            ->fluentlyGetOrSet('type')
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
            rtrim(Stache::store('advanced-forms.feeds')->directory(), '/'),
            $this->id(),
            'yaml',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function save(): self
    {
        FeedFacade::save($this);

        AdvancedFormsFeedSaved::dispatch($this);

        return $this;
    }

    public function fileData()
    {
        $default = [
            'form' => $this->form()->id(),
            'type' => $this->type()->handle(),
        ];

        $data = \collect($this->data())->all();

        return array_merge($default, $data);
    }
}
