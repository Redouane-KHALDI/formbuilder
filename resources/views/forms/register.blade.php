@extends('layouts.app')

@section('content')
    <body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Registration Form for {{ $country->name }}</h2>
                    </div>
                    <form method="POST" action="{{ route('forms.store') }}" enctype="application/x-www-form-urlencoded"
                          class="card-body">
                        @csrf
                        <input type="hidden" name="country_id" value="{{ $country->id }}">

                        @foreach($formFields as $category => $fields)
                            <h5 class="underline">{{ ucfirst($category) }}</h5>
                            @foreach($fields as $field)
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
                                            <input type="{{ $field->type }}" id="{{ $field->name }}"
                                                   class="form-control mt-3"
                                                   name="{{ $field->name }}" {{ $field->required ? 'required' : '' }}
                                                   value="{{ old($field->name) }}">
                                            @break
                                        @case('textarea')
                                            <textarea id="{{ $field->name }}" name="{{ $field->name }}"
                                                      class="form-control mt-3" {{ $field->required ? 'required' : '' }}>{{ old($field->name) }}</textarea>
                                            @break
                                        @case('dropdown')
                                            <select id="{{ $field->name }}" name="{{ $field->name }}"
                                                    class="form-control mt-3" {{ $field->required ? 'required' : '' }}>
                                                @foreach($field->options as $option)
                                                    <option value="{{ $option }}">{{ $option }}</option>
                                                @endforeach
                                            </select>
                                            @break
                                        @case('radio')
                                            @foreach($field->options as $option)
                                                <label>
                                                    <input type="radio" name="{{ $field->name }}"
                                                           class="form-control mt-3"
                                                           value="{{ $option }}" {{ $field->required ? 'required' : '' }}>
                                                    {{ $option }}
                                                </label>
                                            @endforeach
                                            @break
                                    @endswitch
                                </div>
                            @endforeach
                        @endforeach

                        <button class="btn btn-primary mt-5 px-5" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        @if(auth()->user())
            <a href="/users" class="btn btn-md btn-secondary">Back to Dashboard</a>
        @endif
        <a href="{{ route('forms.index') }}" class="btn btn-md btn-secondary">Forms list</a>
    </div>
    </body>
@endsection
