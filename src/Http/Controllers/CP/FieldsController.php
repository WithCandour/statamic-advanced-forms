<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Statamic\CP\Breadcrumbs;
use Statamic\CP\Column;
use Statamic\Facades\Action;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FormsRepository;

class FieldsController extends Controller
{
    public function index($form)
    {
        return 'Hello';
    }
}
