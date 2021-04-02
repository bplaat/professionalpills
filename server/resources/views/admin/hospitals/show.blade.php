@extends('layout')

@section('title', __('admin/hospitals.show.title', ['hospital.name' => $hospital->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.hospitals.index') }}">@lang('admin/hospitals.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.hospitals.show', $hospital) }}">{{ $hospital->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">{{ $hospital->name }}</h1>

        <h2 class="subtitle is-5">@lang('admin/hospitals.show.address_info')</h2>
        <p>{{ $hospital->address }}</p>
        <p>{{ $hospital->postcode }}, {{ $hospital->city }} {{ $hospital->country }}</p>

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.hospitals.edit', $hospital) }}">@lang('admin/hospitals.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.hospitals.delete', $hospital) }}">@lang('admin/hospitals.show.delete')</a>
        </div>
    </div>
@endsection
