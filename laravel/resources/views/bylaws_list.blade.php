@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> bylaw Postings'])
@section('content')
<div class="container border border-dark rounded mt-3 mb-3" style="background: rgba(220,220,220,0.8);">
    <div class="row p-2">
        <div class="col-12 col-md-4"></div>
        <div class="col-12 col-md-4 text-center">
            <h2>
                <i class="fas fa-gavel"></i>
                Constitution <br />& By-Laws
            </h2>
        </div>
        <div class="col-12 col-md-4 text-md-right">
            <h3>
               <span class="badge badge-primary badge-pill">
                   {{ $data['data']['count'] }} Bylaw {{ Str::plural('Document', $data['data']['count']) }}
               </span>
            </h3>
        </div>
    </div>
    <div class="table-responsive  border border-dark rounded mb-4">
        <table class="table p-1">
            <thead>
                <tr>
                    <th> @sortablelink('title', 'Title') </th>
                    <th> @sortablelink('date', 'Date') </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['data']['bylaws'] as $bylaw)
                    <tr>
                        <td>
                            <p>
                                <a title="{{ $bylaw->title }}" href="{{route('bylaw_show', $bylaw->id)}}">
                                    {{ $bylaw->title }}
                                </a>
                            </p>
                        </td>
                        <td>
                            {{$bylaw->date->format('F j Y')}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        <div class="list-group">
            <ul class="pagination">
                {{$data['data']['bylaws']->links()}}
            </ul>
        </div>
    </div>
</div>
@endsection
