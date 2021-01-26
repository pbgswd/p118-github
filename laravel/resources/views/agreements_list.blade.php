@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> Agreement Postings'])
@section('content')
<div class="container border border-dark rounded-lg mt-3 mb-3" style="background: rgba(220,220,220,0.8);">
    <div class="col-12 mb-3 pt-2">
        <h1>
            <i class="far fa-handshake"></i>
            Collective Agreements
        </h1>
        <h3>
           <span class="badge badge-primary badge-pill">
               {{ $data['data']['count'] }} agreement postings
           </span>
        </h3>
    </div>
    <div class="col-12 p-0 border border-dark rounded-lg mb-3" style="background: rgba(220,220,220,0.8);">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th> @sortablelink('title', 'Title') </th>
                        <th> @sortablelink('from', 'From') </th>
                        <th> @sortablelink('until', 'Until') </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($data['data']['agreements'] as $agreement)
                    <tr>
                        <td>
                            <h5>
                                @if(\Carbon\Carbon::parse($agreement->until)->isPast())
                                    <i>(Not current)</i>
                                @endif
                                <a title="{{ $agreement->title }}" href="{{route('agreement_show', $agreement->id)}}">
                                    {{ $agreement->title }}
                                </a>
                            </h5>
                        </td>
                        <td>
                            {{ $agreement->from->format('F j Y') }}
                        </td>
                        <td>
                            {{ $agreement->until->format('F j Y') }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="list-group">
            <ul class="pagination">
                {{$data['data']['agreements']->links()}}
            </ul>
        </div>
    </div>
</div>
@endsection
