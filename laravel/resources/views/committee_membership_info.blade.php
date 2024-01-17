@section('content')
<div class="col-12 p-lg-2 mt-lg-3 border border-dark rounded">
    <h4>
        <span class="badge badge-primary badge-pill">
            {{$c->active_committee_members->count()}}
        </span>
        {{Str::plural('Member', $c->active_committee_members->count())}}.
        @if(0 < $c->active_committee_members->count())
            <a href="{{route('committee_list_members', $data['committee']->slug)}}">View membership</a>
        @endif
    </h4>
    @if($data['isMember'] != 1)
        <form method="post" name="committee-join" action="{{ url()->current() }}/join" enctype="multipart/form-data" class="needs-validation" novalidate>
            {!! csrf_field() !!}
            <div class="col">
                <button value="Join" class="btn btn-success" type="submit">Join {{$c->name}}</button>
            </div>
        </form>
    @else
        <h5>You are a member of {{$c->name}}</h5>
        <form method="post" name="committee-leave" action="{{ url()->current() }}/leave"  enctype="multipart/form-data" class="needs-validation" novalidate>
            {!! csrf_field() !!}
            <div class="col">
                <button value="Leave" class="btn btn-outline-dark" type="submit">Leave {{$c->name}}</button>
            </div>
        </form>
    @endif
</div>
@endsection
