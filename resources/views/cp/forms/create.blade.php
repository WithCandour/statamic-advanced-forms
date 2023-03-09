@extends('statamic::layout')
@section('title', __('Create Form'))

@section('content')
    <form-create-form
        route="{{ cp_route('advanced-forms.store') }}">
    </form-create-form>
@stop
