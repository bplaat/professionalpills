@extends('layout')

@section('title', __('admin/trails.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.trails.index') }}">@lang('admin/trails.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/trails.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('admin.trails.create') }}">@lang('admin/trails.index.create')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('admin/trails.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/trails.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($trails->count() > 0)
            {{ $trails->links() }}

            <div class="columns is-multiline">
                @foreach ($trails as $trail)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title is-4">
                                <a href="{{ route('admin.trails.show', $trail) }}">{{ $trail->name }}</a>

                                @if ($trail->running)
                                    <span class="tag is-pulled-right is-success">@lang('admin/trails.index.running')</span>
                                @endif
                            </h2>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $trails->links() }}
        @else
            <p><i>@lang('admin/trails.index.empty')</i></p>
        @endif
    </div>
@endsection
