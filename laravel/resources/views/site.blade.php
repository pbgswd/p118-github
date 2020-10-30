@extends('layouts.jumbo')
@section('content')
    <div class="container">
        <div class="row border border-dark rounded-lg p-3">
            <div class="col-6">

                <h2>
                  Hi {{Auth::user()->name}}
                </h2>
            </div>

        </div>
        @include('content_feature')
    </div>
@endsection
