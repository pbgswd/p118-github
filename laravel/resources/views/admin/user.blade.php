@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i> ' . $data["action"]
            . ' Member ' . ($data["action"] == "Edit" ? $data['user']->name : '') ])
@section('content')
<script>
    tinymce.init({
        selector: 'textarea#admin_notes, textarea#about',
        height: 200,
        width:800,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor textcolor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify ' +
            '| bullist numlist outdent indent | removeformat | help',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tiny.cloud/css/codepen.min.css'
        ]
    });
</script>
<div class="container mb-lg-5">
    <div class="row">
        <div class="col-4">
            <h4>
                <a href="{{ route('users_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i> List of members
                </a>
            </h4>
        </div>
        <div class="col-4">
            <h4>
                <a title="public profile for {{ $data['user']->name }}" target="_blank"
                   href="{{ route('member', $data['user']->id) }}">
                    <i class="far fa-user-circle"></i> View public profile
                </a>
            </h4>
        </div>
    </div>
    <form method="post" name="user" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row border border-primary rounded-lg border-3 mt-lg-4 p-lg-1 mb-lg-3">
            <div class="col-lg-12">
                <h3>Primary Contact Information</h3>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                    <input type="text" class="form-control"  placeholder="Name" name="user[name]"
                           value="{{ old('user.name', $data['user']->name)}}" size="80" required/>
                </div>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                <input type="text" class="form-control"  placeholder="Email" name="user[email]"
                       value="{{ old('user.email', $data['user']->email ?? null)}}" size="80" required/>
                </div>
            </div>
            <div class="col-12 input-group mb-6">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input name="user_info[share_email]" type="hidden" value="0" />
                        <input name="user_info[share_email]" type="checkbox" value="1"
                            {{ checked(old('user_info.share_email', $data['user']->user_info->share_email ?? null)) }} />
                    </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox"
                       value="Share email in profile?" size="40" readonly>
            </div>
            <div class="col-12 input-group mb-3 mt-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Phone</span>
                   <input type="text" class="form-control"  placeholder="Phone" name="user_phone[phone_number]"
                          value="{{ old('user_phone.phone_number', $data['user']->phone_number->phone_number ?? '')}}"
                          size="80" required/>
                </div>
            </div>
            <div class="input-group mb-2 col-12">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input name="user_info[share_phone]" type="hidden" value="0" />
                        <input name="user_info[share_phone]" type="checkbox"
                               value="1"
                            {{ checked(old('user_info.share_phone', $data['user']->user_info->share_phone ?? '')) }} />
                    </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox"
                       value="Share phone number in profile?" size="40" readonly>
            </div>
        </div>
        @if ($data['action'] == 'Edit')
            <div class="row border border-primary rounded-lg border-3 mt-lg-1 pb-3 mb-lg-3">
                <div class="col-12 pt-3">
                    <h4>Committee Memberships</h4>
                    <p>
                        <a href="{{route('committees_list')}}">
                            Go to Committees Admin
                        </a>
                    </p>
                    @foreach($data['user']->committee_memberships as $c)
                        <h4>
                            <a href="{{route('admin_committee_show', $c->slug)}}">
                                {{$c->name}}
                            </a>
                             {{$c->pivot->role}}
                            <a href="{{route('admin_edit_committee_members', [$c->slug, $data['user']->id])}}">
                                <i class="far fa-edit"></i> Edit
                            </a>
                        </h4>
                    @endforeach
                </div>
            </div>
            <div class="row border border-primary rounded-lg border-3 mt-lg-1 pb-3">
                <div class="col-6 pt-3">
                    <h4>Executive Title & Email</h4>
                </div>
                <div class="col-6 pt-3 mb-3 text-right">
                    <a href="{{route('admin_executive_create', $data['user']->id)}}">
                        <h4>Create new Executive Role <i class="far fa-arrow-alt-circle-right"></i></h4>
                    </a>
                </div>
                @if($data['user']->allExecutiveRoles->count() > 0)
                    <div class="col-12 pt-3">
                            @foreach($data['user']->allExecutiveRoles as $e)
                                <h4>
                                    {!! $e->pivot->current ? "<b>Currently:</b> "
                                        : '' !!}
                                    {{$e->title}},
                                    from {{\Carbon\Carbon::parse($e->pivot->start_date)->format('F j Y')}},
                                    until {{\Carbon\Carbon::parse($e->pivot->end_date)->format('F j Y')}}.
                                    <a href="{{route('admin_executive_edit', $e->pivot->id)}}"
                                       title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </h4>
                                <br />
                            @endforeach
                    </div>
                @endif
            </div>
        @endif
        <div class="row border border-primary rounded-lg border-3 p-lg-3 mt-3 mb-3">
            <div class="col-12">
                <h4>Member Info</h4>
            </div>
            <div class="input-group mb-3 col-12">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input name="user_info[show_profile]" type="hidden" value="0" />
                        <input name="user_info[show_profile]" type="checkbox"
                               value="1"
                                {{ checked(old('user_info.show_profile', $data['user']->user_info->show_profile ?? '')) }} />
                    </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox"
                       value="Check to share profile with other members." size="80" readonly>
            </div>
            <div class="row mt-lg-3">
                @if( isset($data['user']->user_info->image) )
                    <div class="col-4 mt-lg-1 mb-3">
                        <h4><i class="far fa-images"></i> Profile Image</h4>
                        <h5>Currently: {{ $data['user']->user_info->file_name }}</h5>
                        <img src="{{ asset('storage/users/'. $data['user']->user_info->image) }}" width="150px" />
                        <input type="hidden"  name="user_info[image]" value="{{$data['user']->user_info->image}}" />
                    </div>
                    <div class="input-group mb-3 col-12">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input name="user_info[show_profile]" type="checkbox" value="1" />
                            </div>
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                               value="Check to delete image." size="40" readonly>
                    </div>
                    <div class="input-group mb-lg-3 col-12 mt-lg-1">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input name="user_info[show_picture]" type="hidden" value="0" />
                                <input name="user_info[show_picture]" type="checkbox"
                                       value="1"
                                    {{ checked(old('user_info.show_picture', $data['user']->user_info->show_picture ?? '')) }}
                                />
                            </div>
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                               value="Check to show picture in your profile." size="40" readonly>
                    </div>
                @else
                    <div class="col-12 mt-lg-3">
                        <div class="form-group">
                            <label for="exampleInputFile">
                                <i class="fas fa-cloud-upload-alt fa-2x"></i>
                                File input
                            </label>
                            <input type="file" id="inputFile" name="image" />
                            <p class="help-block">
                                Upload image for your profile if you wish.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-12 mt-lg-4">
                <h4>Member personal profile info</h4>
            </div>
            <div class="col-12">
                <textarea name="user_info[about]" id="about" class="form-control">
                    {{ old('user_info.about', $data['user']->user_info->about ?? '') }}
                </textarea>
            </div>
        </div>
        <div class="row border border-primary rounded-lg border-3 mt-lg-1 p-lg-1">
            <div class="col-12"><h3>Primary Mailing Address</h3></div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Apt#</span>
                </div>
                <input type="text" class="form-control" placeholder="Apt #" name="user_address[unit]"
                       value="{{ old('user_address.unit', $data['user']->address->unit ?? '') }}" size="60" />
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Street</span>
                </div>
                <input type="text" class="form-control" placeholder="Street" name="user_address[street]"
                       value="{{ old('user_address.street', $data['user']->address->street ?? '') }}" size="60"/>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">City</span>
                </div>
                <input type="text" class="form-control" placeholder="City" name="user_address[city]"
                       value="{{ old('user_address.city', $data['user']->address->city ?? '')}}" size="40"/>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Province</span>
                </div>
            {{ select_options($data['provinces'],
                old('user_address.province', $data['user']->address->province ?? ''),
                ['name' => 'user_address[province]', 'class' => 'form-control', 'placeholder' => 'Province']) }}
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"> Postal Code</span>
                </div>
                    <input type="text" style="text-transform:uppercase" class="form-control"
                           placeholder="Postal Code" name="user_address[postal_code]"
                           value="{{ old('user_address.postal_code', strtoupper($data['user']->address->postal_code ?? ''))}}"
                           size="60" />
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Country</span>
                </div>
                 {{ select_options($data['countries'],
                    old('user_address.country', $data['user']->address->country ?? ''),
                    ['name' => 'user_address[country]', 'class' => 'form-control', 'placeholder' => 'Country']) }}
            </div>
        </div>

        <div class="row border border-primary rounded-lg border-3 mt-lg-2 p-lg-2">
            <div class="col-md-12">
                <h4>Membership type & details</h4>
                <p>Member, office, or possibly other types in the future</p>
                @foreach ($data['membership'] as $k => $v)
                    {{$k}} => {{$v}} <br />
                @endforeach


                Seniority: {{$data['user']->membership->seniority_number ?? ''}} <br />
                Since: {{$data['user']->membership->membership_date ?? ''}}<br /><br />
                Admin notes: <br />
                <textarea name="membership[admin_notes]" id="membership_admin_notes" class="form-control">
                    {{ old('membership.admin_notes', $data['user']->membership->admin_notes ?? '') }}
                </textarea>
            </div>
        </div>

        <div class="row border border-primary rounded-lg border-3 mt-lg-2 p-lg-2">
            <div class="col-md-12">
                <h4>User website admin access roles </h4>
                <p>Use this section to grant access to members for managing content.</p>
                <ul>
                    <li>A member is 'member' by default, and just has access to login.</li>
                    <li>A writer is a member who can update content in sections of the site.
                        Committee privileges are not a part of this. </li>
                    <li>An access level of 'office' allows for office staff to manage users.</li>
                    <li>Super-admin access is for full do everything access.</li>
                </ul>

            </div>

            @foreach ($data['roles'] as $role)
                <div class="col-md-12 mb-6">
                    <div class="input-group">
                        <div class="input-group-prepend mr-lg-2">
                            <div class="input-group-text">
                                <input name="user_role" type="radio" value="{{$role->name}}"
                                    {{ checked(array_key_exists($role->name, $data['user_roles'])) }}
                                />
                            </div><strong  class="pl-lg-2">{{$role->name}}</strong>
                        </div>
                        @forelse ($role->permissions as $p)
                            <i> {{ $p->name }}, </i> &nbsp;
                        @empty
                            <i>No advanced permissions</i>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mt-lg-4">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
            <div class="col-sm"> &nbsp;
            </div>
                @if ($data['action'] == 'Edit')
                    @hasanyrole('super-admin|admin')
                     <div class="col-sm" style="float:right">
                         <form name="delete" method="POST" action="{{route('user_destroy')}}">
                             {!! csrf_field() !!}
                             {!! method_field('DELETE') !!}
                            <i class="far fa-trash-alt fa-2x"></i>
                            <input type="hidden" name="id[]" value="{{ $data['user']->id }}">
                            <input class="btn btn-outline-danger" type="submit" value="Delete">
                        </form>
                     </div>
                    @endhasanyrole
                @endif
            </div>
        </div>
@endsection
