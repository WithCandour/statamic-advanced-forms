@extends('statamic::layout')
@section('title', $title)


@section('content')
    <breadcrumbs :crumbs='@json($breadcrumb)'></breadcrumbs>
    <h1 class="mb-3">{{ $title }}</h1>

    @if ($values)
        <publish-form
            :title="__('Values')"
            :blueprint='@json($blueprint)'
            :meta='@json($meta)'
            :values='@json($values)'
            read-only
        ></publish-form>
    @endif

    <h1 class="mb-1">Notes</h1>
    <advanced-forms-submission-notes
        :feed-notes='@json($feed_notes)'
        :notification-notes='@json($notification_notes)'
    ></advanced-forms-submission-notes>
@endsection
