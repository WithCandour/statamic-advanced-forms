@extends('statamic::layout')
@section('title', __('advanced-forms::feeds.configure'))

@section('content')

    <header class="mb-3">
        <breadcrumbs :crumbs='@json($breadcrumb)'></breadcrumbs>
        <h1>@yield('title')</h1>
    </header>

    <advanced-forms-feed-edit-form
        :blueprint="{{ json_encode($blueprint) }}"
        :initial-values="{{ json_encode($values) }}"
        :meta="{{ json_encode($meta) }}"
        url="{{ cp_route('advanced-forms.feeds.update', ['advanced_form' => $form->id(), 'feed' => $feed->id()]) }}"
        form-url="{{ $form->showUrl() }}"
    ></advanced-forms-feed-edit-form>

@stop
