@extends('layout')

@section('title', __('home.title'))

@section('content')
    <div class="content">
        @auth
            <h1 class="title">@lang('home.auth_header', ['user.firstname' => Auth::user()->firstname])</h1>
            <p>@lang('home.auth_description')</p>

            <h2 class="subtitle">@lang('home.auth_local_hospital')</h2>

            @php($hospitalId = session('random_hospital_id') ?? App\Models\Hospital::pluck('id')->random())
            @php(session(['random_hospital_id' => $hospitalId]))
            @php($hospital = App\Models\Hospital::find($hospitalId))
            <div class="columns is-multiline">
                <div class="column is-one-third">
                    <div class="box content" style="height: 100%">
                        <h2 class="title is-4">
                            <a href="{{ route('hospitals.show', $hospital) }}">{{ $hospital->name }}</a>
                        </h2>
                        <p>{{ $hospital->address }}</p>
                        <p>{{ $hospital->postcode }}, {{ $hospital->city }} {{ $hospital->country }}</p>
                    </div>
                </div>
            </div>
        @else
            <h1 class="title">@lang('home.guest_header', ['app.name' => config('app.name')])</h1>
            <p>@lang('home.guest_description')</p>
        @endauth
    </div>
@endsection
