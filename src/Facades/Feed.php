<?php

namespace WithCandour\StatamicAdvancedForms\Facades;

use Illuminate\Support\Facades\Facade;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FeedsRepository;

class Feed extends Facade
{
    /**
     * @method static \Illuminate\Support\Collection all()
     * @method static \WithCandour\StatamicAdvancedForms\Contracts\Feed|null find(string $id)
     * @method static \Illuminate\Support\Collection findByForm(WithCandour\StatamicAdvancedForms\Contracts\Form $form)
     * @method static \WithCandour\StatamicAdvancedForms\Contracts\Feed make(string $handle)
     * @method static \WithCandour\StatamicAdvancedForms\Contracts\Feed save(WithCandour\StatamicAdvancedForms\Contracts\Feed $feed)
     * @method static void delete(\WithCandour\StatamicAdvancedForms\Contracts\Feed $feed)
     *
     * @see \WithCandour\StatamicAdvancedForms\Contracts\Repositories\FeedsRepository
     */
    protected static function getFacadeAccessor()
    {
        return FeedsRepository::class;
    }
}
