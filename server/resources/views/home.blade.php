@extends('layout')

@section('title', __('home.title'))

@section('content')
    <div class="content">
        @auth
            <h1 class="title is-spaced">@lang('home.auth_header', ['user.firstname' => Auth::user()->firstname])</h1>
            <p>@lang('home.auth_description')</p>
        @else
            <h1 class="title is-spaced">@lang('home.guest_header', ['app.name' => config('app.name')])</h1>
            <p>@lang('home.guest_description')</p>
        @endauth
    </div>
@endsection
