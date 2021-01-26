@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
    <div class="jumbotron">
        <div class="container border border-dark rounded-lg mb-3" style="background: rgba(220,220,220,0.8);">
            <h1>Meetings & Minutes</h1>
            <h3>
               <span class="badge badge-primary badge-pill">
                   {{ $data['count'] }} Meetings & Minutes
               </span>
            </h3>

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
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <div class="list-group">
                    <ul class="pagination">
                        {{$data['meetings']->links()}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
