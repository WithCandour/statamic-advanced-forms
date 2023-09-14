@extends('statamic::layout')
@section('title', $title)


@section('content')
    <breadcrumbs :crumbs='@json($breadcrumb)'></breadcrumbs>
    <h1 class="mb-3">{{ $title }}</h1>

    <advanced-forms-edit-form
        action="{{ cp_route('advanced-forms.update', $form->id()) }}"
        method="patch"
        initial-title="{{ $form->title() }}"
        initial-description="{{ $form->description() }}"
        initial-confirmation="{{ $form->confirmationMessage() }}"
        initial-expires="{{ $form->expiresEntries() }}"
        initial-lifespan="{{ $form->entryLifespan() }}"
        index-url="{{ $form->showUrl() }}"
    ></advanced-forms-edit-form>
@endsection
