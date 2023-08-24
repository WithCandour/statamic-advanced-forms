@extends('statamic::layout')
@section('title', $title)

@section('content')
<breadcrumbs :crumbs='@json($breadcrumb)'></breadcrumbs>
<div class="flex items-center justify-between mb-3">
    <h1 class="m-0">{{ $title }}</h1>
    <a href="{{ cp_route('advanced-forms.edit', $form->id()) }}" class="btn">{{ __('Edit') }}</a>
</div>
<div class="card p-3 mb-3">
    <div class="flex justify-between items-center mb-3">
        <div class="flex items-center">
            <h2>{{ __('advanced-forms::submissions.recent') }}</h2>
        </div>
        <a href="{{ cp_route('advanced-forms.submissions.index',  $form->id()) }}" class="btn">
            {{ __('View all') }}
        </a>
    </div>
    @if($submissions->isEmpty())
        <div class="text-center border-2 border-dashed rounded-md p-3">
            <h3 class="mb-1 text-grey text-sm">No submissions</h3>
        </div>
    @else
        <advanced-forms-submissions-listing
            :initial-per-page="10"
            :initial-columns="{{ json_encode($submissions_initial_columns) }}"
            form-id="{{ $form->id() }}"
            action-url="{{ $submissions_action_url }}"
        ></advanced-forms-submissions-listing>
    @endif
</div>
<div class="card p-3 mb-3">
    <div class="flex justify-between items-center mb-1">
        <div class="flex items-center">
            <h2>{{ __('advanced-forms::fields.title') }}</h2>
        </div>
        <a href="{{ cp_route('advanced-forms.fields.edit',  $form->id()) }}" class="btn">
            {{ __('Edit') }}
        </a>
    </div>
    <div class="flex items-center">
        <div class="mr-2 badge-pill-sm"><span class="text-grey-80 font-medium">Pages:</span> {{ $fields_page_count }}</div>
        <div class="mr-2 badge-pill-sm"><span class="text-grey-80 font-medium">Fields:</span> {{ $fields_field_count }}</div>
    </div>
</div>
<div class="card p-3 mb-3">
    <div class="flex justify-between items-center mb-3">
        <div class="flex items-center">
            <div>
                <h2>{{ __('advanced-forms::notifications.title') }}</h2>
                <p class="text-sm text-grey">{{ __('advanced-forms::notifications.introduction') }}</p>
            </div>
        </div>
        <a href="{{ cp_route('advanced-forms.notifications.create',  $form->id()) }}" class="btn-primary">
            {{ __('Create') }}
        </a>
    </div>
    @if($notifications->isEmpty())
        <div class="text-center border-2 border-dashed rounded-md p-3">
            <h3 class="mb-1 text-grey text-sm">No notifications configured</h3>
            <a href="{{ cp_route('advanced-forms.notifications.create',  $form->id()) }}" class="btn-primary">
                {{ __('Create') }}
            </a>
        </div>
    @else
        <advanced-forms-notifications-listing
            :initial-columns="{{ json_encode($notifications_initial_columns) }}"
            form-id="{{ $form->id() }}"
            action-url="{{ $notifications_action_url }}"
        ></advanced-forms-notifications-listing>
    @endif
</div>
<div class="card p-3 mb-3">
    <div class="flex justify-between items-center mb-3">
        <div class="flex items-center">
            <div>
                <h2>{{ __('advanced-forms::feeds.title') }}</h2>
                <p class="text-sm text-grey">{{ __('advanced-forms::feeds.introduction') }}</p>
            </div>
        </div>
        <advanced-forms-create-button
            url="{{ cp_route('advanced-forms.feeds.create', $form->id()) }}"
            :feed-types="{{ json_encode($feed_types) }}"
            button-class="btn-primary"
        />
    </div>
    @if($feeds->isEmpty())
        <div class="text-center border-2 border-dashed rounded-md p-3">
            <h3 class="mb-1 text-grey text-sm">No feeds configured</h3>
            <advanced-forms-create-button
                url="{{ cp_route('advanced-forms.feeds.create', $form->id()) }}"
                :feed-types="{{ json_encode($feed_types) }}"
                button-class="btn-primary"
            />
        </div>
    @else
        <advanced-forms-feeds-listing
            :initial-columns="{{ json_encode($feeds_initial_columns) }}"
            form-id="{{ $form->id() }}"
            action-url="{{ $feeds_action_url }}"
        ></advanced-forms-feeds-listing>
    @endif
</div>
@endsection
