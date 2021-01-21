@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
<div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.8);">
    <h1>
       <span class="badge badge-primary badge-pill">
           {!! $data['count'] ?? 0 !!}
       </span>
        Members.
    </h1>
    <h5>
        <a href="{{route('member', Auth::user()->id)}}">
            View my profile
            <i class="far fa-arrow-alt-circle-right"></i>
        </a>
    </h5>
    <div class="table-responsive-md border border-dark rounded-lg p-1"
         style="background: rgba(220,220,220,0.8); margin-left:auto; margin-right:auto;">
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
                            @if (!empty($i->user_info->show_profile) OR (Auth::user()->id == $i->id))
                                <a title="{{ $i->name }}" href="{{ route('member', $i->id) }}">
                                    {{ $i->name }}
                                </a>
                            @else
                                {{ $i->name }}
                            @endif
                        </h4>

                            <i>
                                {{$i->membership['membership_type'] ?? 'no type'}}
                            </i>

                        @forelse($i->currentExecutiveRoles as $a)
                            <a href="mailto:{{$a->email}}" title="email {{$i->name}} at {{$a->email}}">
                                <i class="fas fa-envelope"></i>
                            </a>
                            {{$a->title}}
                            {{\Carbon\Carbon::parse($a->pivot->start_date)->format('M j Y')}}
                             - {{\Carbon\Carbon::parse($a->pivot->end_date)->format('M j Y')}}
                            <br />
                            @empty
                        @endforelse
                    </td>
                    <td>
                        @if (!empty($i->user_info->share_email) )
                            <a href="mailto:{{ $i->email }}">
                                {{ $i->email }}
                            </a>
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
