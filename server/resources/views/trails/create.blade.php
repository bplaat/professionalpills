@extends('layout')

@section('title', __('trails.create.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('trails.index') }}">@lang('trails.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('trails.create') }}">@lang('trails.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('trails.create.header')</h1>

    <form method="POST" action="{{ route('trails.store') }}">
        @csrf

        <div class="field">
            <label class="label" for="hospital_id">@lang('trails.create.hospital')</label>

            <div class="control">
                <div class="select is-fullwidth @error('hospital_id') is-danger @enderror">
                    <select id="hospital_id" name="hospital_id" required>
                        @foreach (Auth::user()->hospitals as $hospital)
                            <option value="{{ $hospital->id }}" @if ($hospital->id == old('hospital_id', request('hospital_id'))) selected @endif>
                                {{ $hospital->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @error('hospital_id')
                <p class="help is-danger">{{ $errors->first('hospital_id') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="name">@lang('trails.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name') }}" autofocus required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="description">@lang('trails.create.description')</label>

            <div class="control">
                <textarea class="textarea @error('description') is-danger @enderror" id="description" name="description">{{ old('description') }}</textarea>
            </div>

            @error('description')
                <p class="help is-danger">{{ $errors->first('description') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="limit">@lang('trails.create.limit')</label>

            <div class="control">
                <input class="input @error('limit') is-danger @enderror" type="number" id="limit" name="limit" min="1" max="1000" value="{{ old('limit', 100) }}" />
            </div>

            @error('limit')
                <p class="help is-danger">{{ $errors->first('limit') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('trails.create.button')</button>
            </div>
        </div>
    </form>
@endsection
