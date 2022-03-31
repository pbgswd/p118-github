@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])
@section('content')
<div class="container border border-dark rounded-lg mt-3 mb-3" style="background: rgba(220,220,220,0.8);">
    <div class="row d-flex justify-content-around pb-md-3">
        <div class="col-0 col-md-4">
        </div>
        <div class="col-12 col-md-4 text-center">
            <h1>
                Member List
            </h1>
        </div>
        <div class="col-12 col-md-4 text-center text-md-right font-weight-bolder">
            <h5>
                <a href="{{route('member', Auth::user()->id)}}">
                    <i class="fas fa-user text-primary"></i> View your profile
                </a>
            </h5>
        </div>
        <div class="col-12 text-center">
            <h6>
               <span class="badge badge-primary badge-pill">
                   {{ $data['count'] ?? 0 }}
               </span>
                Members
            </h6>
        </div>
    </div>

    <div class="table-responsive-md border border-dark rounded-lg">
        <table class="table">
            <thead>
                <tr>
                    <th> @sortablelink('name', 'Name') </th>
                    <th> </th>
                    <th>
                        <i class="fas fa-phone-square"></i>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $data['users'] as $i )
                    <tr>
                        <td>
                            <h5>
                                @if ((true === $i->user_info->show_profile) OR (Auth::user()->id == $i->id))
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
                                {{$a->title}} <br />
                            @empty
                            @endforelse
                            @forelse($i->committee_memberships as $cm)
                                <a href="{{route('committee', $cm->slug)}}" title="{{$cm->name}}">
                                    {{$cm->name}}{!! $loop->last ? '.' : ', <br />' !!}
                                </a>
                            @empty
                            @endforelse
                            @if (!empty($i->user_info->share_email) )
                                <span class="d-sm-block d-md-none">
                                     <a href="mailto:{{ $i->email }}">
                                          <i class="fas fa-envelope"></i>
                                    </a>
                                </span>
                                <span class="d-none d-md-block">
                                    <h5 style="white-space: nowrap;">
                                        <a href="mailto:{{ $i->email }}">
                                            <i class="fas fa-envelope"></i>
                                            {{ $i->email }}
                                        </a>
                                    </h5>
                                </span>
                            @endif
                        </td>
                        <td class="p-2 pr-3">
                            @if (!empty($i->user_info->share_phone) )

                                <span class="d-sm-block d-md-none">
                                    <a href="tel:{{ $i->phone_number->phone_number }}">
                                        <i class="fas fa-phone-square"></i>
                                    </a>
                                </span>
                                <span class="d-none d-md-block">
                                    <h5 style="white-space: nowrap;">
                                        <a href="tel:{{ $i->phone_number->phone_number }}">
                                            <i class="fas fa-phone-square"></i> {{ $i->phone_number->phone_number }}
                                        </a>
                                    </h5>
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
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
