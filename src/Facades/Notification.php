<?php

namespace WithCandour\StatamicAdvancedForms\Facades;

use Illuminate\Support\Facades\Facade;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\NotificationsRepository;

class Notification extends Facade
{
    /**
     * @method static \Illuminate\Support\Collection all()
     * @method static \WithCandour\StatamicAdvancedForms\Contracts\Notification|null find(string $id)
     * @method static \Illuminate\Support\Collection findByForm(WithCandour\StatamicAdvancedForms\Contracts\Form $form)
     * @method static \WithCandour\StatamicAdvancedForms\Contracts\Notification make(string $handle)
     * @method static \WithCandour\StatamicAdvancedForms\Contracts\Notification save(WithCandour\StatamicAdvancedForms\Contracts\Notification $feed)
     * @method static void delete(\WithCandour\StatamicAdvancedForms\Contracts\Notification $feed)
     *
     * @see \WithCandour\StatamicAdvancedForms\Contracts\Repositories\NotificationsRepository
     */
    protected static function getFacadeAccessor()
    {
        return NotificationsRepository::class;
    }
}
