<?php

use Illuminate\Support\Facades\Route;

Route::namespace('\WithCandour\StatamicAdvancedForms\Http\Controllers\CP')
    ->prefix('advanced-forms')
    ->name('advanced-forms.')
    ->group(function () {

        Route::resource('/', 'FormsController')
            ->except(['edit']);

        Route::post('forms/actions', 'Actions\\FormActionController@run')->name('forms.actions.run');
        Route::post('forms/actions/list', 'Actions\\FormActionController@bulkActions')->name('forms.actions.bulk');

    });
