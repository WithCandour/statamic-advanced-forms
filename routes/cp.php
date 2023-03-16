<?php

use Illuminate\Support\Facades\Route;

Route::namespace('\WithCandour\StatamicAdvancedForms\Http\Controllers\CP')
    ->group(function () {
        Route::resource('advanced-forms', 'FormsController');

        Route::post('advanced-forms/actions', 'Actions\\FormActionController@run')->name('advanced-forms.actions.run');
        Route::post('advanced-forms/actions/list', 'Actions\\FormActionController@bulkActions')->name('advanced-forms.actions.bulk');

        Route::get('advanced-forms/{advanced_form}/fields', 'FieldsController@index')->name('advanced-forms.fields.edit');
        Route::patch('advanced-forms/{advanced_form}/fields', 'FieldsController@update')->name('advanced-forms.fields.update');

        Route::resource('advanced-forms.notifications', 'NotificationsController')
            ->only(['create', 'update', 'edit', 'destroy']);

        Route::resource('advanced-forms.feeds', 'FeedsController')
            ->only(['create', 'update', 'edit', 'destroy']);

    });
