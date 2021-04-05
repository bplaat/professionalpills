@extends('layout')

@section('title', __('trails.show.title', ['trail.name' => $trail->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('trails.index') }}">@lang('trails.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('trails.show', $trail) }}">{{ $trail->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">{{ $trail->name }}</h1>

        @if ($trail->running)
            <p><span class="tag is-success">@lang('trails.show.running')</span></p>
        @endif

        <p>@lang('trails.show.hospital') <a href="{{ route('hospitals.show', $trail->hospital) }}">{{ $trail->hospital->name }}</a></p>

        <p>@lang('trails.show.limit') {{ $trail->limit }}</p>

        @if ($trail->description != null)
            <p>{{ $trail->description }}</p>
        @endif

        @canany(['run', 'update', 'delete'], $trail)
            <div class="buttons">
                @can('run', $trail)
                    @if (!$trail->running)
                        <a class="button is-success" href="{{ route('trails.run', $trail) }}">@lang('trails.show.run')</a>
                    @endif
                @endcan

                @can('update', $trail)
                    <a class="button is-link" href="{{ route('trails.edit', $trail) }}">@lang('trails.show.edit')</a>
                @endcan

                @can('delete', $trail)
                    <a class="button is-danger" href="{{ route('trails.delete', $trail) }}">@lang('trails.show.delete')</a>
                @endcan
            </div>
        @endcanany
    </div>

    <!-- Trail users -->
    <div class="box content">
        <h2 class="title is-4">@lang('trails.show.users')</h2>

        @if ($trailUsers->count() > 0)
            {{ $trailUsers->links() }}

            <div class="columns is-multiline">
                @php($i = 1)
                @foreach ($trailUsers as $user)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h3 class="title is-4">
                                {{ $user->name }}

                                @if ($user->pivot->enrolled)
                                    <span class="tag is-pulled-right is-success">@lang('trails.show.users_enrolled')</span>
                                @else
                                    <span class="tag is-pulled-right is-warning">@lang('trails.show.users_waiting')</span>
                                @endif
                            </h3>

                            @if ($i > $trail->limit)
                                <p>@lang('trails.show.users_place') <strong>{{ $i - $trail->limit }}</strong></p>
                            @elseif (!$trail->running)
                                <p>@lang('trails.show.users_enough')</p>
                            @endif

                            @if (!$trail->running)
                                @can('delete_trail_user_form', $trail)
                                    <div class="buttons">
                                        <a class="button is-danger is-light is-small" href="{{ route('trails.users.delete', [$trail, $user]) }}">@lang('trails.show.users_remove_button')</a>
                                    </div>
                                @else
                                    @if ($user->id == Auth::id())
                                        <div class="buttons">
                                            <a class="button is-danger is-light is-small" href="{{ route('trails.users.delete', [$trail, $user]) }}">@lang('trails.show.users_remove_yourself_button')</a>
                                        </div>
                                    @endif
                                @endcan
                            @endif
                        </div>
                    </div>

                    @php($i++)
                @endforeach
            </div>

            {{ $trailUsers->links() }}
        @else
            <p><i>@lang('trails.show.users_empty')</i></p>
        @endif

        @if (!$trail->running && $trailUsers->count() != $users->count())
            @can('create_trail_user_form', $trail)
                <form method="POST" action="{{ route('trails.users.create', $trail) }}">
                    @csrf

                    <div class="field has-addons">
                        <div class="control">
                            <div class="select @error('user_id') is-danger @enderror">
                                <select id="user_id" name="user_id" required>
                                    <option selected disabled>
                                        @lang('trails.show.users_field')
                                    </option>

                                    @foreach ($users as $user)
                                        @if (!$trailUsers->pluck('id')->contains($user->id))
                                            <option value="{{ $user->id }}"  @if ($user->id == old('user_id')) selected @endif>
                                                {{ $user->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="control">
                            <button class="button is-link" type="submit">@lang('trails.show.users_add_button')</button>
                        </div>
                    </div>
                </form>
            @else
                @if (!$trail->users->pluck('id')->contains(Auth::id()))
                    <form method="POST" action="{{ route('trails.users.create', $trail) }}">
                        @csrf

                        <input type="hidden" name="user_id" value="{{ Auth::id() }}" />

                        <div class="buttons">
                            <button class="button is-link" type="submit">@lang('trails.show.users_add_yourself_button')</button>
                        </div>
                    </form>
                @endif
            @endcan
        @endif
    </div>
@endsection
