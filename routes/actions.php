<?php

use Illuminate\Support\Facades\Route;

Route::namespace('\WithCandour\StatamicAdvancedForms\Http\Controllers\Actions')
    ->group(function () {

        Route::post('forms/{advanced_form}', 'FormController@submit')
            ->name('advanced-forms.submit');

    });
