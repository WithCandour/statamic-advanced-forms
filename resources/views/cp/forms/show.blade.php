@extends('statamic::layout')
@section('title', $title)

@section('content')
<breadcrumbs :crumbs='@json($breadcrumb)'></breadcrumbs>
<div class="flex items-center justify-between mb-3">
    <h1 class="m-0">{{ $title }}</h1>
    <a href="{{ cp_route('advanced-forms.edit', $form['id']) }}" class="btn">{{ __('Edit') }}</a>
</div>
<div class="card p-0 mb-3">
    <div class="p-2">
        <h2>{{ __('advanced-forms::submissions.recent') }}</h2>
    </div>
</div>
<div class="card p-2 mb-3">
    <div class="flex justify-between items-center mb-1">
        <div class="flex items-center">
            <div class="w-5 h-5 mr-2">@cp_svg('drawer-file')</div>
            <h2>{{ __('advanced-forms::fields.title') }}</h2>
        </div>
        <a href="{{ cp_route('advanced-forms.fields.edit',  $form['id']) }}" class="btn">
            {{ __('Edit') }}
        </a>
    </div>
    <div class="flex items-center">
        <div class="mr-2 badge-pill-sm"><span class="text-grey-80 font-medium">Pages:</span> 1</div>
        <div class="mr-2 badge-pill-sm"><span class="text-grey-80 font-medium">Fields:</span> 5</div>
    </div>
</div>
<div class="card p-2 mb-3">
    <div class="flex justify-between items-center mb-3">
        <div class="flex items-center">
            <div class="w-5 h-5 mr-2">@cp_svg('email-utility')</div>
            <div>
                <h2>{{ __('advanced-forms::notifications.title') }}</h2>
                <p class="text-sm text-grey">{{ __('advanced-forms::notifications.introduction') }}</p>
            </div>
        </div>
        <a href="{{ cp_route('advanced-forms.notifications.create',  $form['id']) }}" class="btn-primary">
            {{ __('Create') }}
        </a>
    </div>
    <div class="text-center border-2 border-dashed rounded-md p-3">
        <h3 class="mb-1 text-grey text-sm">No notifcations configured</h3>
        <a href="{{ cp_route('advanced-forms.notifications.create',  $form['id']) }}" class="btn-primary">
            {{ __('Create') }}
        </a>
    </div>
</div>
<div class="card p-2 mb-3">
    <div class="flex justify-between items-center mb-3">
        <div class="flex items-center">
            <div class="w-5 h-5 mr-2">@cp_svg('synchronize')</div>
            <div>
                <h2>{{ __('advanced-forms::feeds.title') }}</h2>
                <p class="text-sm text-grey">{{ __('advanced-forms::feeds.introduction') }}</p>
            </div>
        </div>
        <a href="{{ cp_route('advanced-forms.notifications.create',  $form['id']) }}" class="btn-primary">
            {{ __('Create') }}
        </a>
    </div>
    <div class="text-center border-2 border-dashed rounded-md p-3">
        <h3 class="mb-1 text-grey text-sm">No feeds configured</h3>
        <a href="{{ cp_route('advanced-forms.feeds.create',  $form['id']) }}" class="btn-primary">
            {{ __('Create') }}
        </a>
    </div>
</div>
@endsection
