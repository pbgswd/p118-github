@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
<div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6);">
    <h1>
       <span class="badge badge-primary badge-pill">
           {!! $data['users']->total()  !!}
       </span>
        Members.
    </h1>
    <h5>
        <a href="{{route('member', Auth::user()->id)}}">View my profile <i class="far fa-arrow-alt-circle-right"></i></a>
    </h5>
    <div class="table-responsive-md border border-dark rounded-lg p-1" style="background: rgba(220,220,220,0.6); margin-left:auto; margin-right:auto;">
        <table class="table table-sm" style="margin-left:auto; margin-right:auto;">
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
                            @if (!empty($i->user_info->show_profile))
                                <a title="{{ $i->name }}" href="{{ route('member', $i->id) }}">
                            @endif
                            {{ $i->name }}
                            @if (!empty($i->user_info->show_profile))
                                </a>
                            @endif
                        </h4>
                    </td>
                    <td>
                        @if (!empty($i->user_info->share_email))
                        <a href="mailto:{{ $i->email }}">{{ $i->email }}</a>
                        @endif
                    </td>
                </tr>
            @endforeach
                <tr>
                    <td colspan="6">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row mt-lg-2 mb-lg-4">
        <div class="col-5"></div>
        <div class="col-3">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['users']->links() !!}
                </ul>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
@endsection
