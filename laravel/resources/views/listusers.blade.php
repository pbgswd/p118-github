@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])

@section('content')
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6);">
    <h1 class="display-3"></h1>
        <h3>
           <span class="badge badge-primary badge-pill">
               {!! $data['users']->total()  !!}
           </span>
            Members. | <a href="{{route('member', Auth::user()->id)}}">View my profile <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
</div>

    <div class="table-responsive-md border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;  max-width:768px;">
        <table class="table table-dark table-sm">
            <thead>
                <tr>
                      <th> @sortablelink('name', 'Name') </th>
                    <th> @sortablelink('email', 'Email') </th>
                </tr>
            </thead>
            <tbody>
            @foreach ( $data['users'] as $i )
                <tr>
                    <td>
                        <h4>
                            <a title="{{ $i->name }}" href="{{ route('member', $i->id) }}">{{ $i->name }}</a>
                        </h4>
                    </td>
                    <td> {{ $i->email }} </td>
                </tr>
            @endforeach
                <tr>
                    <td colspan="6">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['users']->links() !!}
                </ul>
            </div>
        </div>
        <div class="col"></div>
    </div>

    <div class="row" style="margin-top:6em;"></div>
@endsection
