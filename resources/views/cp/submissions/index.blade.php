@extends('statamic::layout')
@section('title', $title)


@section('content')
    <breadcrumbs :crumbs='@json($breadcrumb)'></breadcrumbs>
    <h1 class="mb-3">{{ $title }}</h1>

    @if($submissions->isEmpty())
        <div class="text-center border-2 border-dashed rounded-md p-3">
            <h3 class="mb-1 text-grey text-sm">No submissions</h3>
        </div>
    @else
        <advanced-forms-submissions-listing
            :initial-columns="{{ json_encode($submissions_initial_columns) }}"
            :paginated="true"
            form-id="{{ $form->id() }}"
            action-url="{{ $action_url }}"
        ></advanced-forms-submissions-listing>
    @endif
@endsection
