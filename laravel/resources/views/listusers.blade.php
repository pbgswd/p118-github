@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
<div class="container border border-dark rounded-lg mt-3 mb-3" style="background: rgba(220,220,220,0.8);">
    <div class="row">
        <div class="col-12 col-md-6">
            <h1>
               <span class="badge badge-primary badge-pill">
                   {!! $data['count'] ?? 0 !!}
               </span>
                Members
            </h1>
        </div>
        <div class="col-12 col-md-6 text-md-right">
            <h5>
                <a href="{{route('member', Auth::user()->id)}}">
                    View my profile
                    <i class="far fa-arrow-alt-circle-right"></i>
                </a>
            </h5>
        </div>
    </div>
    <div class="table-responsive-md border border-dark rounded-lg">
        <table class="table">
            <thead>
                <tr>
                    <th> @sortablelink('name', 'Name') </th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $data['users'] as $i )
                    <tr>
                        <td>
                            <h5>
                                @if (!empty($i->user_info->show_profile) OR (Auth::user()->id == $i->id))
                                    <a title="{{ $i->name }}" href="{{ route('member', $i->id) }}">
                                        {{ $i->name }}
                                    </a>
                                @else
                                    {{ $i->name }}
                                @endif
                            </h5>
                            @if($i->membership['membership_type'] != 'Member')
                                <i>
                                    {{$i->membership['membership_type'] ?? 'no type'}}
                                </i>
                            @endif
                        </td>
                        <td>
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
                            @if (!empty($i->user_info->share_email) )
                                <a href="mailto:{{ $i->email }}">
                                    {{ $i->email }}
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-12 mt-3">
        <div class="d-flex justify-content-center">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['users']->links() !!}
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection
