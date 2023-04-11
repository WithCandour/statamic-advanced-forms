<?php

use Illuminate\Support\Facades\Route;

Route::namespace('\WithCandour\StatamicAdvancedForms\Http\Controllers\Actions')
    ->group(function () {

        Route::post('forms/{advanced_form}', 'FormController@submit')
            ->name('advanced-forms.submit');

        // /!/statamic-anonymous-forms/download-anonymous-asset
        Route::get('download-anonymous-asset', 'AnonymousAssetsDownloadController@download');

    });
