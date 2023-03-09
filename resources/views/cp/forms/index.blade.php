@extends('statamic::layout')
@section('title', __('advanced-forms::messages.title'))


@section('content')
    @unless($forms->isEmpty())



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
