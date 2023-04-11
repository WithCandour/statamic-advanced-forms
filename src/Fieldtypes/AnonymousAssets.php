<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Illuminate\Support\Facades\Crypt;
use Statamic\Fieldtypes\Assets\Assets as AssetsFieldtype;
use Statamic\Support\Arr;
use Statamic\Facades\URL;

class AnonymousAssets extends AssetsFieldtype
{
    protected $canCreate = false;

    public function preProcess($values)
    {
        return $values;
    }

    /**
     * @inheritDoc
     */
    public function process($data)
    {
        $actionRoute = config('statamic.routes.action', '!');

        $urls = \collect($data)
            ->map(fn($id) => '/' . $actionRoute . '/statamic-advanced-forms/download-anonymous-asset?key=' . Crypt::encryptString($id));

        return $this->config('max_files') === 1 ? $urls->first() : $urls->all();
    }

    /**
     * @inheritDoc
     */
    public function augment($values)
    {
        $values = collect(Arr::wrap($values))
            ->map(function($value) {
                return URL::makeAbsolute($value);
            });

        return $this->config('max_files') === 1 ? $values->first() : $values->all();
    }

    /**
     * @inheritDoc
     */
    public function shallowAugment($values)
    {
        $values = collect(Arr::wrap($values));

        return $this->config('max_files') === 1 ? $values->first() : $values->all();
    }

    /**
     * @inheritDoc
     */
    public function view()
    {
        $default = 'statamic-advanced-forms::fieldtypes.anonymous_assets';

        return view()->exists($default)
            ? $default
            : 'statamic::forms.fields.default';
    }
}
