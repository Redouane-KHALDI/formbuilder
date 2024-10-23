@extends('layouts.app')

@section('content')
    <body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                @if(session('success') || session('error'))
                    <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">
                        {{ session('success') ?? session('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Edit User Registration for {{ $country->name }}</h2>
                    </div>
                    <form method="POST" action="{{ route('forms.update', $country->id) }}"
                          enctype="application/x-www-form-urlencoded"
                          class="card-body">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="country_id" value="{{ $country->id }}">
                        <input type="hidden" name="user_id" value="{{ $userRegistration->user_id }}">

                        @foreach($formFields as $field)
                            <div class="form-group">
                                <label for="{{ $field->name }}" class="form-label">
                                    {{ $field->name }}
                                    @if($field->required)
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                @if($errors->has($field->name))
                                    <span class="text-danger">{{ $errors->first($field->name) }}</span>
                                @endif
                                @switch($field->type)
                                    @case('text')
                                    @case('number')
                                    @case('password')
                                    @case('date')
                                    @case('file')
                                    @case('checkbox')
                                    @case('email')
                                        <input type="{{ $field->type }}" id="{{ $field->name }}" class="form-control mt-3" name="{{ $field->name }}" value="{{ old($field->name, $jsonData[$field->name] ?? '') }}" {{ $field->required ? 'required' : '' }}>
                                        @break
                                    @case('textarea')
                                        <textarea id="{{ $field->name }}" name="{{ $field->name }}" class="form-control mt-3" {{ $field->required ? 'required' : '' }}>{{ old($field->name, $jsonData[$field->name] ?? '') }}</textarea>
                                        @break
                                    @case('dropdown')
                                        <select id="{{ $field->name }}" name="{{ $field->name }}" class="form-control mt-3" {{ $field->required ? 'required' : '' }}>
                                            @foreach($field->options as $option)
                                                <option value="{{ $option }}" {{ $jsonData[$field->name] == $option ? 'selected' : '' }}>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                        @break
                                    @case('radio')
                                        @foreach($field->options as $option)
                                            <label>
                                                <input type="radio" name="{{ $field->name }}" class="form-control mt-3" value="{{ $option }}" {{ $jsonData[$field->name] == $option ? 'checked' : '' }} {{ $field->required ? 'required' : '' }}>
                                                {{ $option }}
                                            </label>
                                        @endforeach
                                        @break
                                @endswitch
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                        <a href="/users/" class="btn btn-info mt-3">Go To Dashboard</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection
