@extends('statamic::layout')
@section('title', __('advanced-forms::messages.title'))


@section('content')
    @unless($forms->isEmpty())

        <div class="flex items-center mb-3">
            <h1 class="flex-1">{{ __('advanced-forms::messages.title') }}</h1>
            <a href="{{ cp_route('advanced-forms.create') }}" class="btn-primary">{{ __('Create Form') }}</a>
        </div>

        <advanced-forms-listing
            :initial-columns="{{ json_encode($initialColumns) }}"
            action-url="{{ $actionUrl }}"
        ></advanced-forms-listing>

    @else
        @include('statamic::partials.empty-state', [
            'title' => __('Forms'),
            'description' => __('advanced-forms::messages.form_configure_intro'),
            'svg' => 'empty/form',
            'button_text' => __('Create Form'),
            'button_url' => cp_route('advanced-forms.create'),
        ])
    @endunless

@endsection
