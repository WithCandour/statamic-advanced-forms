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
    @else

    @endif
@endsection
