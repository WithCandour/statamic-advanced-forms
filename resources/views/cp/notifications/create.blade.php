@extends('statamic::layout')
@section('title', __('Create Form'))

@section('content')

    <advanced-forms-core-create
        route="{{ cp_route('advanced-forms.notifications.store', [ 'advanced_form' => $form->id() ]) }}"
        heading="{{ __('advanced-forms::notifications.create') }}"
        introduction="{{ __('advanced-forms::notifications.create_introduction') }}"
        title_instructions="{{ __('advanced-forms::notifications.create_title_instructions') }}"
        button_label="{{ __('advanced-forms::notifications.create') }}"
    ></advanced-forms-core-create>

@endsection
