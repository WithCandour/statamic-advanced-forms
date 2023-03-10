<?php

namespace WithCandour\StatamicAdvancedForms;

use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
use Statamic\Facades\Stache;
use Statamic\Providers\AddonServiceProvider;
use WithCandour\StatamicAdvancedForms\Actions\Forms\DeleteFormsAction;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form as FormContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FormsRepository as FormsRepositoryContract;
use WithCandour\StatamicAdvancedForms\Contracts\Stache\Stores\FormsStore as FormsStoreContract;
use WithCandour\StatamicAdvancedForms\Models\Stache\Form;
use WithCandour\StatamicAdvancedForms\Repositories\Stache\FormsRepository;
use WithCandour\StatamicAdvancedForms\Stache\Stores\FormsStore;

class ServiceProvider extends AddonServiceProvider
{
    /**
     * @inheritDoc
     */
    public $singletons = [
        FormsStoreContract::class => FormsStore::class,
        FormsRepositoryContract::class => FormsRepository::class,
    ];

    /**
     * @inheritDoc
     */
    public $bindings = [
        FormContract::class => Form::class,
    ];

    /**
     * @inheritDoc
     */
    protected $routes = [
        'cp' => __DIR__ . '/../routes/cp.php',
    ];

    protected $scripts = [
        __DIR__ . '/../public/js/advanced-forms.js',
    ];

    /**
     * @inheritDoc
     */
    public function bootAddon()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'advanced-forms');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'advanced-forms');

        $this->mergeConfigFrom(__DIR__ . '/../config/advanced-forms.php', 'advanced-forms');

        $this
            ->bootStache()
            ->bootNav()
            ->bootPermissions()
            ->bootActions();
    }

    /**
     * Add our custom stache store.
     *
     * @return self
     */
    public function bootStache(): self
    {
        $stores = \config('advanced-forms.stache.stores', []);

        foreach($stores as $store) {
            $stacheStore = app($store['class'])->directory($store['directory']);
            Stache::registerStore($stacheStore);
        }

        return $this;
    }

    /**
     * Add our custom navigation items.
     *
     * @return self
     */
    public function bootNav(): self
    {
        Nav::extend(function ($nav) {
            $nav->tools('Advanced Forms')
                ->route('advanced-forms.index')
                ->icon('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 18"><g fill="none" fill-rule="evenodd"><path d="M7 16.3335H1.667c-.36837393 0-.667-.2986261-.667-.667V2.9995c.0005517-.36798334.29901624-.666.667-.666H3m8 0h1.334c.3675933.0005507.6654493.29840671.666.666v4.667m-4.666-5.333C8.334 1.59702829 7.73697171 1 7.0005 1c-.73647171 0-1.3335.59702829-1.3335 1.3335H4.334v2h5.333v-2H8.334Z" stroke="currentColor" stroke-width=".66667" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.667 7.6665v-3.667c0-.18391082-.1490892-.333-.333-.333H9.667m-5.333 0H2.667c-.18391082 0-.333.14908918-.333.333v10.667c0 .1839108.14908918.333.333.333H7m-2.666-8.667h5.333m-5.333 2h5.333m-5.333 2H7" stroke="currentColor" stroke-width=".66667" stroke-linecap="round" stroke-linejoin="round"/><path d="M15.7289987 15.1117816v1.1706032c-.9371383.5529312-2.103805.8293968-3.5.8293968-1.39619497 0-2.56286164-.2764656-3.49999998-.8293968v-1.1706032c.80890832.5529311 1.97557499.8293967 3.49999998.8293967 1.524425 0 2.6910917-.2764656 3.5-.8293967Zm0-2v1.1706032c-.9371383.5529312-2.103805.8293968-3.5.8293968-1.39619497 0-2.56286164-.2764656-3.49999998-.8293968v-1.1706032c.80890832.5529311 1.97557499.8293967 3.49999998.8293967 1.524425 0 2.6910917-.2764656 3.5-.8293967Zm0-2v1.1706032c-.9371383.5529312-2.103805.8293968-3.5.8293968-1.39619497 0-2.56286164-.2764656-3.49999998-.8293968v-1.1706032c.80890832.5529311 1.97557499.8293967 3.49999998.8293967 1.524425 0 2.6910917-.2764656 3.5-.8293967Zm-3.5-2.00000004c1.9329966 0 3.5.44771525 3.5 1s-1.5670034 1.00000004-3.5 1.00000004-3.49999998-.44771529-3.49999998-1.00000004 1.56700338-1 3.49999998-1Z" fill="currentColor"/></g></svg>');
        });

        return $this;
    }

    /**
     * Add our custom permissions.
     *
     * @return self
     */
    public function bootPermissions(): self
    {
        Permission::group('advanced-forms', __('advanced-forms::messages.title'), function () {
            Permission::register('access advanced forms', function ($permission) {
                $permission->children([
                    Permission::make('create advanced forms')
                        ->label('Create forms'),
                    Permission::make('delete advanced forms')
                        ->label('Delete forms'),

                    Permission::register('access advanced forms submissions')
                        ->label('View submissions')
                        ->children([
                            Permission::make('delete advanced forms submissions')
                                ->label('Delete submissions'),
                        ]),

                    Permission::make('edit advanced forms fields')
                        ->label('Edit form fields'),

                    Permission::register('access advanced forms feeds')
                        ->label('View feeds')
                        ->children([
                            Permission::make('create advanced forms feeds')
                                ->label('Create feeds'),
                            Permission::make('edit advanced forms feeds')
                                ->label('Edit feeds'),
                            Permission::make('delete advanced forms feeds')
                                ->label('Delete feeds'),
                        ]),

                    Permission::make('access advanced forms notifications')
                        ->label('View notifications')
                        ->children([
                            Permission::make('create advanced forms notifications')
                                ->label('Create notifications'),
                            Permission::make('edit advanced forms notifications')
                                ->label('Edit notifications'),
                            Permission::make('delete advanced forms notifications')
                                ->label('Delete notifications'),
                        ]),

                    Permission::make('download advanced forms assets')
                        ->label('Download files'),
                ]);
            })->label('View forms');
        });

        return $this;
    }

    /**
     * Register our custom actions.
     *
     * @return self
     */
    public function bootActions(): self
    {
        DeleteFormsAction::register();

        return $this;
    }
}
