<?php

use Illuminate\Support\Facades\Route;

Route::namespace('\WithCandour\StatamicAdvancedForms\Http\Controllers\CP')
    ->group(function () {
        Route::resource('advanced-forms', 'FormsController');

        Route::post('advanced-forms/actions', 'Actions\\FormActionController@run')->name('advanced-forms.actions.run');
        Route::post('advanced-forms/actions/list', 'Actions\\FormActionController@bulkActions')->name('advanced-forms.actions.bulk');

        Route::get('advanced-forms/{ form }/fields', 'FieldsController@index')->name('advanced-forms.fields.edit');
        Route::patch('advanced-forms/{ form }/fields', 'FieldsController@update')->name('advanced-forms.fields.update');

        Route::resource('advanced-forms.notifications', 'NotificationsController')
            ->parameters([ 'advanced-forms' => 'form' ])
            ->only(['create', 'update', 'edit', 'destroy']);

        Route::resource('advanced-forms.feeds', 'FeedsController')
            ->parameters([ 'advanced-forms' => 'form' ])
            ->only(['create', 'update', 'edit', 'destroy']);

    });
