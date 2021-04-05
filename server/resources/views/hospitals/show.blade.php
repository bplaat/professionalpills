@extends('layout')

@section('title', __('hospitals.show.title', ['hospital.name' => $hospital->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('hospitals.index') }}">@lang('hospitals.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('hospitals.show', $hospital) }}">{{ $hospital->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">{{ $hospital->name }}</h1>

        <h2 class="subtitle is-5">@lang('hospitals.show.address_info')</h2>
        <p>{{ $hospital->address }}</p>
        <p>{{ $hospital->postcode }}, {{ $hospital->city }} {{ $hospital->country }}</p>

        @canany(['update', 'delete'], $hospital)
            <div class="buttons">
                @can('update', $hospital)
                    <a class="button is-link" href="{{ route('hospitals.edit', $hospital) }}">@lang('hospitals.show.edit')</a>
                @endcan
                @can('delete', $hospital)
                    <a class="button is-danger" href="{{ route('hospitals.delete', $hospital) }}">@lang('hospitals.show.delete')</a>
                @endcan
            </div>
        @endcanany
    </div>

    <!-- Hospital trails -->
    <div class="box content">
        <h2 class="title is-4">@lang('hospitals.show.trails')</h2>

        @if ($hospitalTrails->count() > 0)
            {{ $hospitalTrails->links() }}

            <div class="columns is-multiline">
                @foreach ($hospitalTrails as $trail)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title is-4">
                                <a href="{{ route('trails.show', $trail) }}">{{ $trail->name }}</a>

                                @if ($trail->running)
                                    <span class="tag is-pulled-right is-success">@lang('hospitals.show.trails_running')</span>
                                @endif
                            </h2>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $hospitalTrails->links() }}
        @else
            <p><i>@lang('hospitals.show.trails_empty')</i></p>
        @endif

        @can('create', [App\Models\Trail::class, $hospital])
            <div class="buttons">
                <a class="button is-link" href="{{ route('trails.create') }}?hospital_id={{ $hospital->id }}">@lang('hospitals.show.trails_create')</a>
            </div>
        @endcan
    </div>

    <!-- Hospital users -->
    @can('view_hospital_user', $hospital)
        <div class="box content">
            <h2 class="title is-4">@lang('hospitals.show.users')</h2>

            @if ($hospitalUsers->count() > 0)
                {{ $hospitalUsers->links() }}

                <div class="columns is-multiline">
                    @foreach ($hospitalUsers as $user)
                        <div class="column is-one-third">
                            <div class="box content" style="height: 100%">
                                <h3 class="title is-4">
                                    {{ $user->name }}

                                    @if ($user->pivot->role == App\Models\HospitalUser::ROLE_DRIVER)
                                        <span class="tag is-pulled-right is-success">@lang('hospitals.show.users_role_driver')</span>
                                    @endif

                                    @if ($user->pivot->role == App\Models\HospitalUser::ROLE_NURSE)
                                        <span class="tag is-pulled-right is-warning">@lang('hospitals.show.users_role_nurse')</span>
                                    @endif

                                    @if ($user->pivot->role == App\Models\HospitalUser::ROLE_DOCTOR)
                                        <span class="tag is-pulled-right is-warning">@lang('hospitals.show.users_role_doctor')</span>
                                    @endif

                                    @if ($user->pivot->role == App\Models\HospitalUser::ROLE_RESEARCHER)
                                        <span class="tag is-pulled-right is-danger">@lang('hospitals.show.users_role_researcher')</span>
                                    @endif

                                    @if ($user->pivot->role == App\Models\HospitalUser::ROLE_IT)
                                        <span class="tag is-pulled-right is-dark">@lang('hospitals.show.users_role_it')</span>
                                    @endif
                                </h3>

                                <form method="POST" action="{{ route('hospitals.users.update', [$hospital, $user]) }}">
                                    @csrf

                                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                                    @canany(['update_hospital_user', 'delete_hospital_user'], $hospital)
                                        <div class="field is-grouped">
                                            @can('update_hospital_user', $hospital)
                                                <div class="field has-addons">
                                                    <div class="control">
                                                        <div class="select is-fullwidth is-light is-small @error('role') is-danger @enderror">
                                                            <select id="role" name="role" required>
                                                                <option value="{{ App\Models\HospitalUser::ROLE_DRIVER }}" @if (App\Models\HospitalUser::ROLE_DRIVER == old('role', $user->pivot->role)) selected @endif>
                                                                    @lang('hospitals.show.users_role_field_driver')
                                                                </option>

                                                                <option value="{{ App\Models\HospitalUser::ROLE_NURSE }}" @if (App\Models\HospitalUser::ROLE_NURSE == old('role', $user->pivot->role)) selected @endif>
                                                                    @lang('hospitals.show.users_role_field_nurse')
                                                                </option>

                                                                <option value="{{ App\Models\HospitalUser::ROLE_DOCTOR }}" @if (App\Models\HospitalUser::ROLE_DOCTOR == old('role', $user->pivot->role)) selected @endif>
                                                                    @lang('hospitals.show.users_role_field_doctor')
                                                                </option>

                                                                <option value="{{ App\Models\HospitalUser::ROLE_RESEARCHER }}" @if (App\Models\HospitalUser::ROLE_RESEARCHER == old('role', $user->pivot->role)) selected @endif>
                                                                    @lang('hospitals.show.users_role_field_researcher')
                                                                </option>

                                                                <option value="{{ App\Models\HospitalUser::ROLE_IT }}" @if (App\Models\HospitalUser::ROLE_IT == old('role', $user->pivot->role)) selected @endif>
                                                                    @lang('hospitals.show.users_role_field_it')
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="control">
                                                        <button class="button is-link is-light is-small" type="submit">@lang('hospitals.show.users_edit_button')</button>
                                                    </div>
                                                </div>
                                            @endcan

                                            @can('delete_hospital_user', $hospital)
                                                <div class="field" style="margin-left: 16px;">
                                                    <div class="control">
                                                        <a class="button is-danger is-light is-small" href="{{ route('hospitals.users.delete', [$hospital, $user]) }}">@lang('admin/hospitals.show.users_remove_button')</a>
                                                    </div>
                                                </div>
                                            @endcan
                                        </div>
                                    @endcanany
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $hospitalUsers->links() }}
            @else
                <p><i>@lang('hospitals.show.users_empty')</i></p>
            @endif

            @can('create_hospital_user', $hospital)
                @if ($hospitalUsers->count() != $users->count())
                    <form method="POST" action="{{ route('hospitals.users.store', $hospital) }}">
                        @csrf

                        <div class="field has-addons">
                            <div class="control">
                                <div class="select @error('user_id') is-danger @enderror">
                                    <select id="user_id" name="user_id" required>
                                        <option selected disabled>
                                            @lang('hospitals.show.users_field')
                                        </option>

                                        @foreach ($users as $user)
                                            @if (!$hospitalUsers->pluck('id')->contains($user->id))
                                                <option value="{{ $user->id }}"  @if ($user->id == old('user_id')) selected @endif>
                                                    {{ $user->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="control">
                                <div class="select is-fullwidth @error('role') is-danger @enderror">
                                    <select id="role" name="role" required>
                                        <option value="{{ App\Models\HospitalUser::ROLE_DRIVER }}" @if (App\Models\HospitalUser::ROLE_DRIVER == old('role', App\Models\HospitalUser::ROLE_NURSE)) selected @endif>
                                            @lang('hospitals.show.users_role_field_driver')
                                        </option>

                                        <option value="{{ App\Models\HospitalUser::ROLE_NURSE }}" @if (App\Models\HospitalUser::ROLE_NURSE == old('role', App\Models\HospitalUser::ROLE_NURSE)) selected @endif>
                                            @lang('hospitals.show.users_role_field_nurse')
                                        </option>

                                        <option value="{{ App\Models\HospitalUser::ROLE_DOCTOR }}" @if (App\Models\HospitalUser::ROLE_DOCTOR == old('role', App\Models\HospitalUser::ROLE_NURSE)) selected @endif>
                                            @lang('hospitals.show.users_role_field_doctor')
                                        </option>

                                        <option value="{{ App\Models\HospitalUser::ROLE_RESEARCHER }}" @if (App\Models\HospitalUser::ROLE_RESEARCHER == old('role', App\Models\HospitalUser::ROLE_NURSE)) selected @endif>
                                            @lang('hospitals.show.users_role_field_researcher')
                                        </option>

                                        <option value="{{ App\Models\HospitalUser::ROLE_IT }}" @if (App\Models\HospitalUser::ROLE_IT == old('role', App\Models\HospitalUser::ROLE_NURSE)) selected @endif>
                                            @lang('hospitals.show.users_role_field_it')
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="control">
                                <button class="button is-link" type="submit">@lang('hospitals.show.users_add_button')</button>
                            </div>
                        </div>
                    </form>
                @endif
            @endcan
        </div>
    @endcan
@endsection
