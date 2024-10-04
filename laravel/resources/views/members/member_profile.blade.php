@if ( ($data['user']->user_info->image ?? '') && $data['user']->user_info->show_picture == 1 )
    <div class="col-12 d-flex align-items-center justify-content-center text-center mb-3">
        <picture>
            <source srcset="{{asset('storage/'. $data['folder'] .'/'. $data['user']->user_info->image)}}"
                    media="(min-width: 577px)">
            <img srcset="{{asset('storage/'. $data['folder'] ."/". $data['tn_prefix'].
                                            $data['user']->user_info->image)}}"
                 alt="{{$data['user']->name}}"
                 class="rounded img-fluid w-50">
        </picture>
    </div>
@endif
@if (($data['user']->user_info->share_email ?? '' ) == 1)
    <div class="col-12 text-md-center">
        <h5>
            <a href="mailto:{{$data['user']->email}}" title="Email {{$data['user']->name}}">
                <i class="fas fa-envelope"></i>
                {{$data['user']->email}}
            </a>
        </h5>
    </div>
@endif
@if ($data['user']->user_info->share_phone == 1)
    <div class="col-12 text-md-center">
        <h5>
            <a href="tel:{{$data['user']->phone_number->phone_number ?? '' }}">
                <i class="fas fa-phone-square"></i>
                {{$data['user']->phone_number->phone_number ?? '' }}
            </a>
        </h5>
    </div>
@endif
<div class="col-12 pt-2">
    {!! $data['user']->user_info->about  ?? '' !!}
</div>

<div class="row d-flex justify-content-md-around px-2 mb-2">
    @if( $data['user']->allExecutiveRoles->count() > 0 )
        <div class="col-12 col-md-5 mb-2 p-2 border border-dark rounded justify-content-center">
            <h5>
                Executive {{ Str::plural('Title', $data['user']->allExecutiveRoles->count()) }}
            </h5>
            <ul class="list-group">
                @foreach($data['user']->allExecutiveRoles as $exec)
                    <li class="list-group-item">{{$exec->title}}
                        {{ \Carbon\Carbon::parse($exec->pivot->end_date)->isPast() ? '':'(Currently)'}}
                        <a href="mailto:{{$exec->email}}" title="Email {{$data['user']->name}} {{$exec->title}}
                                        at {{$exec->email}}">
                            <i class="fas fa-envelope"></i>
                        </a>
                        {{\Carbon\Carbon::parse($exec->pivot->start_date)->format('M j Y')}} -
                        {{\Carbon\Carbon::parse($exec->pivot->end_date)->format('M j Y')}}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($data['user']->committee_memberships->count() > 0)
        <div class="col-12 col-md-5 p-2 border border-dark rounded">
            <h5>
                Membership in Committees
            </h5>
            <ul class="list-group">
                @foreach($data['user']->committee_memberships as $m)
                    @if($m->pivot->role != 'Past-Member')
                        <li class="list-group-item">
                            <a href="{{ route('committee', $m->slug) }}" title="{{$m->name}}">
                                {{$m->name}} -  {{$m->pivot->role}}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif
</div>

