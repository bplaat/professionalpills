@extends('layout')

@section('title', __('admin/hospitals.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.hospitals.index') }}">@lang('admin/hospitals.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/hospitals.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('admin.hospitals.create') }}">@lang('admin/hospitals.index.create')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('admin/hospitals.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/hospitals.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($hospitals->count() > 0)
            {{ $hospitals->links() }}

            <div class="columns is-multiline">
                @foreach ($hospitals as $hospital)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title is-4">
                                <a href="{{ route('admin.hospitals.show', $hospital) }}">{{ $hospital->name }}</a>
                            </h2>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $hospitals->links() }}
        @else
            <p><i>@lang('admin/hospitals.index.empty')</i></p>
        @endif
    </div>
@endsection
