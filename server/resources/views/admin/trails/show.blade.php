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

        @if ($trail->running)
            <p><span class="tag is-success">@lang('admin/trails.show.running')</span></p>
        @endif

        <p>@lang('admin/trails.show.hospital') <a href="{{ route('admin.hospitals.show', $trail->hospital) }}">{{ $trail->hospital->name }}</a></p>

        <p>@lang('admin/trails.show.limit') {{ $trail->limit }}</p>

        @if ($trail->description != null)
            <p>{{ $trail->description }}</p>
        @endif

        <div class="buttons">
            @if (!$trail->running)
                <a class="button is-success" href="{{ route('admin.trails.run', $trail) }}">@lang('admin/trails.show.run')</a>
            @endif
            <a class="button is-link" href="{{ route('admin.trails.edit', $trail) }}">@lang('admin/trails.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.trails.delete', $trail) }}">@lang('admin/trails.show.delete')</a>
        </div>
    </div>

    <!-- Trail users -->
    <div class="box content">
        <h2 class="title is-4">@lang('admin/trails.show.users')</h2>

        @if ($trailUsers->count() > 0)
            {{ $trailUsers->links() }}

            <div class="columns is-multiline">
                @php($i = 1)
                @foreach ($trailUsers as $user)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h3 class="title is-4">
                                <a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a>

                                @if ($user->pivot->enrolled)
                                    <span class="tag is-pulled-right is-success">@lang('admin/trails.show.users_enrolled')</span>
                                @else
                                    <span class="tag is-pulled-right is-warning">@lang('admin/trails.show.users_waiting')</span>
                                @endif
                            </h3>

                            @if ($i > $trail->limit)
                                <p>@lang('admin/trails.show.users_place') <strong>{{ $i - $trail->limit }}</strong></p>
                            @elseif (!$trail->running)
                                <p>@lang('admin/trails.show.users_enough')</p>
                            @endif

                            @if (!$trail->running)
                                <div class="buttons">
                                    <a class="button is-danger is-light is-small" href="{{ route('admin.trails.users.delete', [$trail, $user]) }}">@lang('admin/trails.show.users_remove_button')</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    @php($i++)
                @endforeach
            </div>

            {{ $trailUsers->links() }}
        @else
            <p><i>@lang('admin/trails.show.users_empty')</i></p>
        @endif

        @if (!$trail->running && $trailUsers->count() != $users->count())
            <form method="POST" action="{{ route('admin.trails.users.create', $trail) }}">
                @csrf

                <div class="field has-addons">
                    <div class="control">
                        <div class="select @error('user_id') is-danger @enderror">
                            <select id="user_id" name="user_id" required>
                                <option selected disabled>
                                    @lang('admin/trails.show.users_field')
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
                        <button class="button is-link" type="submit">@lang('admin/trails.show.users_add_button')</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection
