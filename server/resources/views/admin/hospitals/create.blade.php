@extends('layout')

@section('title', __('admin/hospitals.create.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.hospitals.index') }}">@lang('admin/hospitals.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.hospitals.create') }}">@lang('admin/hospitals.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/hospitals.create.header')</h1>

    <form method="POST" action="{{ route('admin.hospitals.store') }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/hospitals.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name') }}" autofocus required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="address">@lang('admin/hospitals.create.address')</label>

                    <div class="control">
                        <input class="input @error('address') is-danger @enderror" type="text" id="address" name="address" value="{{ old('address') }}" required>
                    </div>

                    @error('address')
                        <p class="help is-danger">{{ $errors->first('address') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="postcode">@lang('admin/hospitals.create.postcode')</label>

                    <div class="control">
                        <input class="input @error('postcode') is-danger @enderror" type="text" id="postcode" name="postcode" value="{{ old('postcode') }}" required>
                    </div>

                    @error('postcode')
                        <p class="help is-danger">{{ $errors->first('postcode') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="city">@lang('admin/hospitals.create.city')</label>

                    <div class="control">
                        <input class="input @error('city') is-danger @enderror" type="text" id="city" name="city" value="{{ old('city') }}" required>
                    </div>

                    @error('city')
                        <p class="help is-danger">{{ $errors->first('city') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="country">@lang('admin/hospitals.create.country')</label>

                    <div class="control">
                        <div class="select is-fullwidth @error('country') is-danger @enderror">
                            <select id="country" name="country" required>
                                @foreach (App\Models\User::COUNTRIES as $country)
                                    <option {{ $country == old('country', 'Netherlands') ? 'selected' : '' }} value="{{ $country }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @error('country')
                        <p class="help is-danger">{{ $errors->first('country') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/hospitals.create.button')</button>
            </div>
        </div>
    </form>
@endsection
