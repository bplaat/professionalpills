@extends('layout')

@section('title', __('trails.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li class="is-active"><a href="{{ route('trails.index') }}">@lang('trails.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('trails.index.header')</h1>

        <div class="columns">
            <div class="column">
                <!-- %BUG -->
                @if (App\Models\HospitalUser::where('user_id', Auth::id())->where('role', '>=', App\Models\HospitalUser::ROLE_RESEARCHER)->count() > 0)
                    <div class="buttons">
                        <a class="button is-link" href="{{ route('trails.create') }}">@lang('trails.index.create')</a>
                    </div>
                @endif
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('trails.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('trails.index.search_button')</button>
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
                                <a href="{{ route('trails.show', $trail) }}">{{ $trail->name }}</a>

                                @if ($trail->running)
                                    <span class="tag is-pulled-right is-success">@lang('trails.index.running')</span>
                                @endif
                            </h2>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $trails->links() }}
        @else
            <p><i>@lang('trails.index.empty')</i></p>
        @endif
    </div>
@endsection
