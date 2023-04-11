@extends('statamic::layout')
@section('title', $title)


@section('content')
    <breadcrumbs :crumbs='@json($breadcrumb)'></breadcrumbs>
    <h1 class="mb-3">{{ $title }}</h1>
@endsection
