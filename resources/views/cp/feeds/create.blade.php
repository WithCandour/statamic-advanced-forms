@extends('statamic::layout')
@section('title', __('Create Form'))

@section('content')

    <advanced-forms-core-create
        route="{{ cp_route('advanced-forms.feeds.store', [ 'advanced_form' => $form->id() ]) }}"
        heading="{{ __('advanced-forms::feeds.create') }}"
        introduction="{{ __('advanced-forms::feeds.create_introduction') }}"
        title_instructions="{{ __('advanced-forms::feeds.create_title_instructions') }}"
        button_label="{{ __('advanced-forms::feeds.create') }}"
    ></advanced-forms-core-create>

@endsection
