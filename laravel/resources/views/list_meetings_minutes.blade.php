@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
        <div class="container border border-dark rounded-lg mt-3" style="background: rgba(220,220,220,0.8);">
            <div class="row d-flex justify-content-around mb-2 mb-md-3">
                <div class="col-12 col-md-4"></div>
                <div class="col-12 col-md-4 text-center">
                    <h1>Meeting Minutes</h1>
                </div>
                <div class="col-12 col-md-4 text-md-right">
                    <h3>
                       <span class="badge badge-primary badge-pill">
                           {{ $data['count'] }} Meeting {{ Str::plural('Minute', $data['count']) }}
                       </span>
                    </h3>
                </div>
            </div>
            <form method="post" action="{{route('post_year')}}">
                @csrf
                <div class="row d-fle justify-content-around border border-dark rounded-lg pb-2 m-2 mb-3 mb-md-3">
                    <div class="col-12 pt-2">
                        <h5>
                            <label for="validationDefault04">
                                View Minutes By Year
                            </label>
                        </h5>
                    </div>
                    <div class="col-12 col-md-9 mb-2">
                        <select class="custom-select" name="year" id="validationDefault04" required>
                            <option selected disabled value="">Choose Year</option>
                            @foreach($data['years'] as $year)
                                <option value="{{$year->year}}">{{$year->year}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>

                <div class="col-12 mt-3 mb-3 mb-md-3">
                    <h4>
                        @if($data['year'] !='')
                            Meeting Minutes for
                            <span class="font-weight-bold">
                                {{$data['year']}}
                            </span>
                        @else
                            Most recent {{$data['pagination']}} meetings
                        @endif
                    </h4>
                </div>

            <div class="table-responsive border border-dark rounded-lg mb-2">
                <table class="table">
                    <thead>
                        <tr>
                            <th> @sortablelink('title', 'Title') </th>
                            <th> @sortablelink('date', 'Date') </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $data['meetings'] as $a )
                            <tr>
                                <td>
                                    <h5>
                                        <a title="{{ $a->title }}" href="{{route('meeting', $a->id)}}">
                                            {{ $a->title }}
                                        </a>
                                    </h5>
                                </td>
                                <td> {{ $a->date->format('F j Y') }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="{{$data['year'] == '' ? 'd-none d-md-block' : ''}}">
                <div class="d-flex justify-content-center mt-3">
                    <div class="list-group">
                        <ul class="pagination">
                            {!! $data['meetings']->links() !!}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
@endsection
