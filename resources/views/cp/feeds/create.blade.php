@extends('statamic::layout')
@section('title', $title)

@section('content')

    <advanced-forms-feed-create-form
        route="{{ cp_route('advanced-forms.feeds.store', [ 'advanced_form' => $form->id() ]) }}"
        heading="{{ $title }}"
        introduction="{{ $introduction }}"
        button_label="{{ __('advanced-forms::feeds.create') }}"
        feed_type="{{ $type }}"
        feed_type_name="{{ $type_name }}"
    ></advanced-forms-feed-create-form>

@endsection
