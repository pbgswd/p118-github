@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
        <div class="container border border-dark rounded mt-3" style="background: rgba(220,220,220,0.8);">
            <div class="row d-flex justify-content-around mb-2 mb-md-3">
                <div class="col-12 mt-3 text-center">
                    <h1>General and Executive Meetings</h1>
                </div>
                @if($data['year'] == '')
                    <div class="col-12 text-center">
                        <h3>
                           <span class="badge rounded-pill text-bg-primary">
                               {{ $data['count'] }} {{ Str::plural('Meeting', $data['count']) }}
                           </span>
                        </h3>
                    </div>
                @endif
            </div>
            <form method="post" action="{{route('post_year')}}">
                @csrf
                <div class="row justify-content-around border border-dark rounded pb-2 m-2 mb-3 mb-md-3">
                    <div class="row">
                        <div class="col-12 pt-2">
                            <h5>
                                @if($data['year'] == '')
                                   View Meetings By Year
                                @else
                                    {{ $data['count'] }} {{ Str::plural('Meeting', $data['count']) }} for {{$data['year']}}
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-12 mb-2">
                            <select class="custom-select" name="year" id="validationDefault04" required>
                                @if($data['year'] == '')
                                    <option selected disabled value="">Choose Year</option>
                                @else
                                    <option selected value="{{$data['year']}}">{{$data['year']}}</option>
                                @endif
                                @foreach($data['years'] as $year)
                                    <option value="{{$year->year}}">{{$year->year}}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-primary" type="submit">Submit</button>
                        </div>
                    </div>
                    @if($data['year'] != '')
                        <div class="row">
                            <div class="col-12 text-sm-center text-lg-start">
                                <a href="{{route('list_meetings')}}">List all Meetings</a>
                            </div>
                        </div>
                    @endif
                </div>
            </form>

            <div class="col-12 mt-3">
                <h4>
                    @if($data['year'] =='')
                        Most recent {{$data['pagination']}} meetings
                    @endif
                </h4>
            </div>

            <div class="table-responsive border border-dark rounded bg-light">
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
