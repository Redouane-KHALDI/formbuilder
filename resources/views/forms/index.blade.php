@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Available Forms by Country</h2>
                    </div>
                    <div class="card-body">
                        <div class="overflow-x-auto">
                            @foreach($countries as $country)
                                @if($country->id !== null)
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item d-flex justify-content-between">
                                        {{ $country->name }}
                                        <a href="{{ route('forms.register', $country->id) }}" class="btn btn-primary">
                                            Subscribe!
                                        </a>
                                    </li>
                                </ol>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
