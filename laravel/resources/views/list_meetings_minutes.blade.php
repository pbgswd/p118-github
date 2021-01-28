@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
    <div class="jumbotron">
        <div class="container border border-dark rounded-lg mb-3" style="background: rgba(220,220,220,0.8);">
            <div class="row d-flex justify-content-around mb-2 mb-md-3">
                <div class="col-12 col-md-6">
                    <h1>Meeting Minutes</h1>
                </div>
                <div class="col-12 col-md-6 text-md-right">
                    <h3>
                       <span class="badge badge-primary badge-pill">
                           {{ $data['count'] }} Meetings & Minutes
                       </span>
                    </h3>
                </div>
            </div>
            <div class="row d-fle justify-content-around border border-dark rounded-lg m-2 mb-md-3">
                @foreach($data['years'] as $year)
                    <div class="col-3 col-md-1 p-2 text-center
                        @if($data['year'] == $year->year)
                            bg-info font-weight-bolder
                        @endif
                        ">
                        <a href="{{route('list_meetings_year', $year->year)}}" title="{{$year->year}}">
                            {{$year->year}}
                        </a>
                    </div>
                @endforeach
            </div>
            @if($data['year'])
                <div class="col-12 mb-md-3">
                    <h4>Meeting Minutes for {{$data['year']}}</h4>
                </div>
            @endif
            <div class="table-responsive border border-dark rounded-lg">
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
