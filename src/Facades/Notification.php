<?php

namespace WithCandour\StatamicAdvancedForms\Facades;

use Illuminate\Support\Facades\Facade;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\NotificationsRepository;

class Notification extends Facade
{
    /**
     * @method static \Illuminate\Support\Collection all()
     * @method static \WithCandour\StatamicAdvancedForms\Contracts\Form|null find(string $id)
     * @method static \WithCandour\StatamicAdvancedForms\Contracts\Form|null findByHandle(string $handle)
     * @method static \WithCandour\StatamicAdvancedForms\Contracts\Form make(string $handle)
     * @method static \WithCandour\StatamicAdvancedForms\Contracts\Form save(WithCandour\StatamicAdvancedForms\Contracts\Form $form)
     * @method static void delete(\WithCandour\StatamicAdvancedForms\Contracts\Form $form)
     *
     * @see \WithCandour\StatamicAdvancedForms\Contracts\Repositories\FormsRepository
     */
    protected static function getFacadeAccessor()
    {
        return NotificationsRepository::class;
    }
}
