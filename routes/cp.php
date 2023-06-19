<?php

use Illuminate\Support\Facades\Route;
use \WithCandour\StatamicAdvancedForms\Http\Controllers\CP\FormsController;
use \WithCandour\StatamicAdvancedForms\Http\Controllers\CP\SettingsController;
use \WithCandour\StatamicAdvancedForms\Http\Controllers\CP\Actions\FormActionController;
use \WithCandour\StatamicAdvancedForms\Http\Controllers\CP\FieldsController;
use \WithCandour\StatamicAdvancedForms\Http\Controllers\CP\NotificationsController;
use \WithCandour\StatamicAdvancedForms\Http\Controllers\CP\Actions\NotificationActionController;
use \WithCandour\StatamicAdvancedForms\Http\Controllers\CP\FeedsController;
use \WithCandour\StatamicAdvancedForms\Http\Controllers\CP\Actions\FeedActionController;
use \WithCandour\StatamicAdvancedForms\Http\Controllers\CP\SubmissionsController;
use \WithCandour\StatamicAdvancedForms\Http\Controllers\CP\Actions\SubmissionActionController;

Route::namespace('\WithCandour\StatamicAdvancedForms\Http\Controllers\CP')
    ->group(function () {

        Route::prefix('advanced-forms')->group(function () {
            Route::post('actions', [FormActionController::class, 'run'])
                ->name('advanced-forms.actions.run');
                
            Route::post('actions/list', [FormActionController::class, 'bulkActions'])
                ->name('advanced-forms.actions.bulk');

            Route::get('{advanced_form}/fields', [FieldsController::class, 'index'])
                ->name('advanced-forms.fields.edit');

            Route::patch('{advanced_form}/fields', [FieldsController::class, 'update'])
                ->name('advanced-forms.fields.update');

            Route::post('notifications/actions', [NotificationActionController::class, 'run'])
                ->name('advanced-forms.notifications.actions.run');

            Route::post('notifications/actions/list', [NotificationActionController::class, 'bulkActions'])
                ->name('advanced-forms.notifications.actions.bulk');

            Route::post('feeds/actions', [FeedActionController::class, 'run'])
                ->name('advanced-forms.feeds.actions.run');

            Route::post('feeds/actions/list', [FeedActionController::class, 'bulkActions'])
                ->name('advanced-forms.feeds.actions.bulk');

            Route::post('submissions/actions', [SubmissionActionController::class, 'run'])
                ->name('advanced-forms.submissions.actions.run');
                
            Route::post('submissions/actions/list', [SubmissionActionController::class, 'bulkActions'])
                ->name('advanced-forms.submissions.actions.bulk');
        });

        Route::resource('advanced-forms', FormsController::class);

        Route::resource('advanced-forms.notifications', NotificationsController::class)
            ->only(['index', 'create', 'store', 'update', 'edit', 'destroy']);

        Route::resource('advanced-forms.feeds', FeedsController::class)
            ->only(['index', 'create', 'store', 'update', 'edit', 'destroy']);

        Route::resource('advanced-forms.submissions', SubmissionsController::class)
            ->only(['index', 'destroy', 'show']);

    });
