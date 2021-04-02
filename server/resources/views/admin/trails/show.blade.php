@extends('layout')

@section('title', __('admin/trails.show.title', ['trail.name' => $trail->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.trails.index') }}">@lang('admin/trails.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.trails.show', $trail) }}">{{ $trail->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">{{ $trail->name }}</h1>
        <p>@lang('admin/trails.show.hospital') <a href="{{ route('admin.hospitals.show', $trail->hospital) }}">{{ $trail->hospital->name }}</a></p>

        @if ($trail->description != null)
            <p>{{ $trail->description }}</p>
        @endif

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.trails.edit', $trail) }}">@lang('admin/trails.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.trails.delete', $trail) }}">@lang('admin/trails.show.delete')</a>
        </div>
    </div>
@endsection