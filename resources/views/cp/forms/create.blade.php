@extends('statamic::layout')
@section('title', __('Create Form'))

@section('content')

    <advanced-forms-create-form
        route="{{ cp_route('advanced-forms.store') }}"
        heading="{{ __('advanced-forms::forms.create') }}"
        introduction="{{ __('advanced-forms::forms.create_introduction') }}"
        title_instructions="{{ __('advanced-forms::forms.create_title_instructions') }}"
        button_label="{{ __('advanced-forms::forms.create') }}"
    ></advanced-forms-create-form>

@endsection
