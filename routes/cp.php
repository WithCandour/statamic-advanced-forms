<?php

use Illuminate\Support\Facades\Route;

Route::namespace('\WithCandour\StatamicAdvancedForms\Http\Controllers\CP')
    ->group(function () {
        Route::resource('advanced-forms', 'FormsController');

        Route::post('advanced-forms/actions', 'Actions\\FormActionController@run')->name('advanced-forms.actions.run');
        Route::post('advanced-forms/actions/list', 'Actions\\FormActionController@bulkActions')->name('advanced-forms.actions.bulk');

        Route::get('advanced-forms/{advanced_form}/fields', 'FieldsController@index')->name('advanced-forms.fields.edit');
        Route::patch('advanced-forms/{advanced_form}/fields', 'FieldsController@update')->name('advanced-forms.fields.update');

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

        Route::prefix('advanced-forms/api')->group(function () {
            Route::post('search', [FormsController::class, 'apiSearch'])->name('advanced-forms.api.search');
        });

        Route::resource('advanced-forms', FormsController::class);

        Route::resource('advanced-forms.notifications', NotificationsController::class)
            ->only(['index', 'create', 'store', 'update', 'edit', 'destroy']);

        Route::post('advanced-forms/notifications/actions', 'Actions\\NotificationActionController@run')->name('advanced-forms.notifications.actions.run');
        Route::post('advanced-forms/notifications/actions/list', 'Actions\\NotificationActionController@bulkActions')->name('advanced-forms.notifications.actions.bulk');

        Route::resource('advanced-forms.feeds', 'FeedsController')
            ->only(['index', 'create', 'store', 'update', 'edit', 'destroy']);

        Route::post('advanced-forms/feeds/actions', 'Actions\\FeedActionController@run')->name('advanced-forms.feeds.actions.run');
        Route::post('advanced-forms/feeds/actions/list', 'Actions\\FeedActionController@bulkActions')->name('advanced-forms.feeds.actions.bulk');

        Route::resource('advanced-forms.submissions', 'SubmissionsController')
            ->only(['index', 'destroy', 'show']);

        Route::post('advanced-forms/submissions/actions', 'Actions\\SubmissionActionController@run')->name('advanced-forms.submissions.actions.run');
        Route::post('advanced-forms/submissions/actions/list', 'Actions\\SubmissionActionController@bulkActions')->name('advanced-forms.submissions.actions.bulk');
    });
