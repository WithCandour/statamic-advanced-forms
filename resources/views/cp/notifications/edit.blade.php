@extends('statamic::layout')
@section('title', __('advanced-forms::notifications.configure'))

@section('content')

    <header class="mb-3">
        <breadcrumbs :crumbs='@json($breadcrumb)'></breadcrumbs>
        <h1>@yield('title')</h1>
    </header>

    <advanced-forms-notification-edit-form
        :blueprint="{{ json_encode($blueprint) }}"
        :initial-values="{{ json_encode($values) }}"
        :meta="{{ json_encode($meta) }}"
        url="{{ cp_route('advanced-forms.notifications.update', ['advanced_form' => $form->id(), 'notification' => $notification->id()]) }}"
    ></advanced-forms-notification-edit-form>

@stop
