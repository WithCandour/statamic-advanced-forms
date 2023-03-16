@extends('statamic::layout')
@section('title', __('Fields'))


@section('content')
    <breadcrumbs :crumbs='@json($breadcrumb)'></breadcrumbs>

    <advanced-forms-fields-builder
        action="{{ cp_route('advanced-forms.fields.update', $form->id()) }}"
        :initial-blueprint='@json($blueprintVueObject)'
        :initial-paginated='@json($paginated)'
    ></advanced-forms-fields-builder>
@endsection
