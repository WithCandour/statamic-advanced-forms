<?php

use Illuminate\Support\Facades\Route;

Route::namespace('\WithCandour\StatamicAdvancedForms\Http\Controllers\CP')
    ->prefix('advanced-forms')
    ->name('advanced-forms.')
    ->group(function () {
        Route::resource('/', 'FormsController');
    });
