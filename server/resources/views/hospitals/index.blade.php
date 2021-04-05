@extends('layout')

@section('title', __('hospitals.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li class="is-active"><a href="{{ route('hospitals.index') }}">@lang('hospitals.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('hospitals.index.header')</h1>

        <div class="columns">
            <div class="column">
                <p>@lang('hospitals.index.description')</p>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('hospitals.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('hospitals.index.search_button')</button>
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
                                <a href="{{ route('hospitals.show', $hospital) }}">{{ $hospital->name }}</a>
                            </h2>
                            <p>{{ $hospital->address }}</p>
                            <p>{{ $hospital->postcode }}, {{ $hospital->city }} {{ $hospital->country }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $hospitals->links() }}
        @else
            <p><i>@lang('hospitals.index.empty')</i></p>
        @endif
    </div>
@endsection
