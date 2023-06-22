<?php

namespace WithCandour\StatamicAdvancedForms;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\Git;
use Statamic\Facades\Permission;
use Statamic\Facades\Stache;
use Statamic\Http\View\Composers\FieldComposer;
use Statamic\Providers\AddonServiceProvider;
use WithCandour\StatamicAdvancedForms\Actions\Feeds\DeleteFeedsAction;
use WithCandour\StatamicAdvancedForms\Actions\Feeds\DisableFeedsAction;
use WithCandour\StatamicAdvancedForms\Actions\Feeds\EnableFeedsAction;
use WithCandour\StatamicAdvancedForms\Actions\Forms\DeleteFormsAction;
use WithCandour\StatamicAdvancedForms\Actions\Notifications\DeleteNotificationsAction;
use WithCandour\StatamicAdvancedForms\Actions\Notifications\DisableNotificationsAction;
use WithCandour\StatamicAdvancedForms\Actions\Notifications\EnableNotificationsAction;
use WithCandour\StatamicAdvancedForms\Actions\Submissions\DeleteSubmissionsAction;
use WithCandour\StatamicAdvancedForms\Contracts\Feeds\FeedTypeRepository as FeedTypeRepositoryContract;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed as FeedContract;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form as FormContract;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification as NotificationContract;
use WithCandour\StatamicAdvancedForms\Contracts\Notifications\Rules\RuleTypeRepository as RuleTypeRepositoryContract;
use WithCandour\StatamicAdvancedForms\Contracts\Processors\FeedProcessor as FeedProcessorContract;
use WithCandour\StatamicAdvancedForms\Contracts\Processors\NotificationProcessor as NotificationProcessorContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FeedNotesRepository as FeedNotesRepositoryContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FormsRepository as FormsRepositoryContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FeedsRepository as FeedsRepositoryContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\NotificationNotesRepository as NotificationNotesRepositoryContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\NotificationsRepository as NotificationsRepositoryContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\SubmissionsRepository as SubmissionsRepositoryContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\SubmissionValuesRepository as SubmissionValuesRepositoryContract;
use WithCandour\StatamicAdvancedForms\Contracts\Stache\Stores\FeedsStore as FeedsStoreContract;
use WithCandour\StatamicAdvancedForms\Contracts\Stache\Stores\FormsStore as FormsStoreContract;
use WithCandour\StatamicAdvancedForms\Contracts\Stache\Stores\NotificationsStore as NotificationsStoreContract;
use WithCandour\StatamicAdvancedForms\Events;
use WithCandour\StatamicAdvancedForms\Feeds\FeedType;
use WithCandour\StatamicAdvancedForms\Feeds\FeedTypeRepository;
use WithCandour\StatamicAdvancedForms\Feeds\FeedTypes\AdvancedFormsExampleFeedType;
use WithCandour\StatamicAdvancedForms\Fieldtypes\AdvancedForms as AdvancedFormsFieldtype;
use WithCandour\StatamicAdvancedForms\Fieldtypes\AdvancedFormsFieldSelect as AdvancedFormsFieldSelectFieldtype;
use WithCandour\StatamicAdvancedForms\Fieldtypes\AnonymousAssets;
use WithCandour\StatamicAdvancedForms\Fieldtypes\AddressLookup;
use WithCandour\StatamicAdvancedForms\Models\Stache\Feed;
use WithCandour\StatamicAdvancedForms\Models\Stache\Form;
use WithCandour\StatamicAdvancedForms\Models\Stache\Notification;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleType;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleTypes\DayOfWeekRuleType;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleTypes\FieldValueRuleType;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleTypes\TimeOfDayRuleType;
use WithCandour\StatamicAdvancedForms\Repositories\Stache\FeedsRepository;
use WithCandour\StatamicAdvancedForms\Repositories\Stache\FormsRepository;
use WithCandour\StatamicAdvancedForms\Repositories\Stache\NotificationsRepository;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleTypeRepository;
use WithCandour\StatamicAdvancedForms\Processors\FeedProcessor;
use WithCandour\StatamicAdvancedForms\Processors\NotificationProcessor;
use WithCandour\StatamicAdvancedForms\Repositories\Eloquent\FeedNotesRepository;
use WithCandour\StatamicAdvancedForms\Repositories\Eloquent\NotificationNotesRepository;
use WithCandour\StatamicAdvancedForms\Repositories\Eloquent\SubmissionsRepository;
use WithCandour\StatamicAdvancedForms\Repositories\Eloquent\SubmissionValuesRepository;
use WithCandour\StatamicAdvancedForms\Stache\Stores\FeedsStore;
use WithCandour\StatamicAdvancedForms\Stache\Stores\FormsStore;
use WithCandour\StatamicAdvancedForms\Stache\Stores\NotificationsStore;
use WithCandour\StatamicAdvancedForms\Tags\AdvancedFormTags;

class ServiceProvider extends AddonServiceProvider
{
    /**
     * @inheritDoc
     */
    public $singletons = [
        FormsStoreContract::class => FormsStore::class,
        FeedsStoreContract::class => FeedsStore::class,
        NotificationsStoreContract::class => NotificationsStore::class,
        FormsRepositoryContract::class => FormsRepository::class,
        FeedsRepositoryContract::class => FeedsRepository::class,
        FeedNotesRepositoryContract::class => FeedNotesRepository::class,
        NotificationsRepositoryContract::class => NotificationsRepository::class,
        NotificationNotesRepositoryContract::class => NotificationNotesRepository::class,
        FeedTypeRepositoryContract::class => FeedTypeRepository::class,
        RuleTypeRepositoryContract::class => RuleTypeRepository::class,
        SubmissionsRepositoryContract::class => SubmissionsRepository::class,
        SubmissionValuesRepositoryContract::class => SubmissionValuesRepository::class,
        FeedProcessorContract::class => FeedProcessor::class,
        NotificationProcessorContract::class => NotificationProcessor::class,
    ];

    /**
     * @inheritDoc
     */
    public $bindings = [
        FormContract::class => Form::class,
        NotificationContract::class => Notification::class,
        FeedContract::class => Feed::class,
    ];

    /**
     * @inheritDoc
     */
    protected $fieldtypes = [
        AdvancedFormsFieldtype::class,
        AdvancedFormsFieldSelectFieldtype::class,
        AnonymousAssets::class,
        AddressLookup::class,
    ];

    /**
     * @var array
     */
    protected $feedTypes = [
        AdvancedFormsExampleFeedType::class,
    ];

    /**
     * @var array
     */
    protected $notificationRuleTypes = [
        DayOfWeekRuleType::class,
        FieldValueRuleType::class,
        TimeOfDayRuleType::class,
    ];

    /**
     * @inheritDoc
     */
    protected $routes = [
        'actions' => __DIR__ . '/../routes/actions.php',
        'cp' => __DIR__ . '/../routes/cp.php',
    ];

    protected $scripts = [
        __DIR__ . '/../public/js/advanced-forms.js'
    ];

    protected $publishables = [
        __DIR__ . '/../resources/js/address-lookup-service.js' => 'js/address-lookup-service.js',
    ];

    protected $tags = [
        AdvancedFormTags::class,
    ];

    /**
     * @inheritDoc
     */
    public function bootAddon()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'advanced-forms');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'advanced-forms');

        $this->mergeConfigFrom(__DIR__ . '/../config/advanced-forms.php', 'statamic.advanced-forms');

        $this->publishes([
            __DIR__ . '/../config/advanced-forms.php' => config_path('statamic/advanced-forms.php'),
        ], 'advanced-forms-config');

        $this->publishes([
            __DIR__ . '/../database/migrations/create_advanced_forms_submissions_table.stub' => $this->migrationsPath('create_advanced_forms_submissions_table.php'),
            __DIR__ . '/../database/migrations/create_advanced_forms_submission_values_table.stub' => $this->migrationsPath('create_advanced_forms_submission_values_table.php'),
            __DIR__ . '/../database/migrations/create_advanced_forms_notification_notes_table.stub' => $this->migrationsPath('create_advanced_forms_notification_notes_table.php'),
            __DIR__ . '/../database/migrations/create_advanced_forms_external_feed_notes_table.stub' => $this->migrationsPath('create_advanced_forms_external_feed_notes_table.php'),
        ], 'advanced-forms-migrations');

        // Make custom fields selectable in forms, if the POSTCODER_API_KEY exists.
        if (env('POSTCODER_API_KEY') !== null && env('POSTCODER_API_KEY' !== ''))
        {
            AddressLookup::makeSelectableInForms();
        }

        $this
            ->bootStache()
            ->bootNav()
            ->bootPermissions()
            ->bootActions()
            ->bootExtensions()
            ->bootViewComposers()
            ->bootGit();
    }

    /**
     * Add our custom stache store.
     *
     * @return self
     */
    public function bootStache(): self
    {
        $stores = \config('statamic.advanced-forms.stache.stores', []);

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

                    Permission::make('download advanced forms anonymous assets')
                        ->label('Download anonymised files'),
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
        EnableFeedsAction::register();
        DisableFeedsAction::register();
        DeleteFeedsAction::register();
        EnableNotificationsAction::register();
        DisableNotificationsAction::register();
        DeleteNotificationsAction::register();
        DeleteSubmissionsAction::register();

        return $this;
    }

    /**
     * Register view composers.
     *
     * @return self
     */
    public function bootViewComposers(): self
    {
        // This ensures we have the fieldtypes in the JS for our blueprint builder.
        View::composer(['advanced-forms::cp.fields.index'], FieldComposer::class);

        return $this;
    }

    /**
     * Register our custom extensions with Statamic
     * - this enables us to use the RegistersItself trait.
     *
     * @return self
     */
    public function bootExtensions()
    {
        $types = [
            'advanced_forms_feed_types' => [
                'class' => FeedType::class,
                'extensions' => $this->feedTypes,
            ],
            'advanced_forms_notification_rule_types' => [
                'class' => RuleType::class,
                'extensions' => $this->notificationRuleTypes,
            ]
        ];

        foreach($types as $key => $type) {
            $this->app->bind('statamic.' . $key, function($app) use ($type) {
                return $app['statamic.extensions'][$type['class']];
            });

            foreach ($type['extensions'] as $extension) {
                $extension::register();
            }
        }

        return $this;
    }

    /**
     * Register addon events with git listener.
     *
     * @return self
     */
    public function bootGit(): self
    {
        if (\config('statamic.git.enabled')) {
            $events = [
                Events\AdvancedFormsFeedSaved::class,
                Events\AdvancedFormsFormSaved::class,
                Events\AdvancedFormsNotificationSaved::class,
            ];

            foreach ($events as $event) {
                Git::listen($event);
            }
        }

        return $this;
    }

    /**
     * Get the migrations path.
     *
     * @param string $filename
     * @return string
     */
    protected function migrationsPath($filename)
    {
        return database_path('migrations/' . date('Y_m_d_His', time()) . "_{$filename}.php");
    }
}
