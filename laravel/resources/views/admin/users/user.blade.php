@extends('layouts.dashboard',  ['title_icon' => ' <i class="fas fa-user"></i>', 'title' => $data["action"] .' Member ' .
    ($data["action"] == "Edit" ? $data['user']->name : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container mb-lg-5">
    <div class="row">
        <div class="col-6">
            <h4>
                <a href="{{ route('users_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List of members
                </a>
            </h4>
        </div>
        @if($data['action'] == 'Edit')
            <div class="col-6 text-md-right">
                <h4>
                    <a title="public profile for {{ $data['user']->name }}" target="_blank"
                       href="{{ route('member', $data['user']->id) }}">
                        <i class="far fa-user-circle"></i>
                        View public profile
                    </a>
                </h4>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <h4>
                <a href="{{route('admin_edit_address', $data['user']->id)}}">
                    <i class="fas fa-address-card text-success"></i>
                    Update address
                </a>
            </h4>
        </div>
        <div class="col-12 col-md-6 text-md-right">
            <h4>
                <a href="{{route('admin_edit_emergency_contact', $data['user']->id)}}">
                    <i class="fas fa-first-aid text-danger"></i>
                    Update emergency contact
                </a>
            </h4>
        </div>
    </div>
    <form method="post" name="user" action="{{ url()->current() }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        @csrf
        <div class="row border border-primary rounded border-3 mt-lg-4 p-lg-1 mb-lg-3">
            <div class="col-12 mt-2 mb-2">
                <h3>Primary Contact Information</h3>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text mb-2" id="inputGroup-sizing-default">Name</span>
                    <input type="text" class="form-control"  placeholder="Name" name="user[name]"
                           value="{{ old('user.name', $data['user']->name)}}" size="80" required/>
                </div>
            </div>

            <div class="input-group col-12 mb-3" style="margin-top: 1rem;">
                <div class="input-group-prepend pb-2">
                    <span class="input-group-text mb-2" id="inputGroup-sizing-default">Email</span>

                <input type="text" class="form-control"  placeholder="Email" name="user[email]"
                       value="{{ old('user.email', $data['user']->email ?? null)}}" size="80" required/>
                </div>
            </div>
            <div class="col-12 input-group mb-3 pb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input name="user_info[share_email]" type="hidden" value="0" />
                        <input name="user_info[share_email]" type="checkbox" value="1"
                            {{ checked(old('user_info.share_email',
                                $data['user']->user_info->share_email ?? null)) }} />
                    </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox"
                       value="Share email in profile?" size="40" readonly>
            </div>
            <div class="col-12 input-group mb-3 mt-2">
                <div class="input-group-prepend">
                   <span class="input-group-text mb-2" id="inputGroup-sizing-default">Phone</span>
                   <input type="tel" class="form-control"  placeholder="Phone" name="user_phone[phone_number]"
                          value="{{ old('user_phone.phone_number', $data['user']->phone_number->phone_number ?? '')}}"
                          size="80"/>
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
            <div class="row border border-primary rounded border-3 mt-1 pb-3 mb-3">
                <div class="col-12 col-md-6 mt-2 mb-2">
                    <h4>Committee Memberships</h4>
                </div>
                <div class="col-12 col-md-6 mt-2 mb-2 text-md-right">
                    <h4>
                        <a href="{{route('committees_list')}}">
                           Committees Admin
                            <i class="far fa-arrow-alt-circle-right"></i>
                        </a>
                    </h4>
                </div>

                <div class="col-12 mt-2 mb-2">
                    @forelse($data['user']->committee_memberships as $c)
                        <h4>
                            <a href="{{route('admin_committee_show', $c->slug)}}">
                                {{$c->name}}
                            </a>
                             {{$c->pivot->role}}
                            <a href="{{route('admin_edit_committee_members', [$c->slug, $data['user']->id])}}">
                                <i class="far fa-edit"></i> Edit
                            </a>
                        </h4>
                    @empty
                        No committee roles for {{$data['user']->name}}.
                    @endforelse
                </div>
            </div>
            <div class="row border border-primary rounded border-3 mt-lg-1 pb-3">
                <div class="col-6  mt-2 mb-2">
                    <h4>Executive Title & Email</h4>
                </div>
                <div class="col-6 pt-3 mb-3 text-right">
                    <a href="{{route('admin_executive_create', $data['user']->id)}}">
                        <h4>Create new Executive Role
                            <i class="far fa-arrow-alt-circle-right"></i>
                        </h4>
                    </a>
                </div>
                <div class="col-12 pt-3">
                    @forelse($data['user']->allExecutiveRoles as $e)
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
                    @empty
                    No executive roles for {{$data['user']->name}}.
                    @endforelse
                </div>
            </div>
        @endif
        <div class="row border border-primary rounded border-3 p-lg-3 mt-3 mb-3">
            <div class="col-12 mt-2 mb-2">
                <h4>Member Info</h4>
            </div>
            <div class="input-group mb-3 col-12">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input name="user_info[show_profile]" type="hidden" value="0" />
                        <input name="user_info[show_profile]" type="checkbox"
                               value="1"
                                {{ checked(old('user_info.show_profile',
                                       $data['user']->user_info->show_profile ?? '')) }} />
                    </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox"
                       value="Check to share profile with other members." size="80" readonly>
            </div>
            <div class="row mt-3">
                @if( isset($data['user']->user_info->image) )
                    <div class="col-12 mt-3 mb-3 mx-auto text-center">
                        <h4>
                            <i class="far fa-images"></i>
                            Profile Image Currently:
                            {{ $data['user']->user_info->file_name }}
                        </h4>
                        <img src="{{ asset('storage/users/'. $data['user']->user_info->image) }}"
                            class="rounded img-fluid w-50 mx-auto" />
                        <input type="hidden" name="user_info[image]" value="{{$data['user']->user_info->image}}" />
                        <input type="hidden" name="user_info[file_name]" value="{{$data['user']->user_info->file_name}}" />

                        <h5>
                            {{$data['filesize'] ?? ''}}
                        </h5>

                        <img src="{{ asset('storage/users/'. $data['user']->user_info->thumb) }}"
                             class="rounded img-fluid mt-5" />
                        <h5>
                            {{$data['user']->user_info->thumb_size ?? ''}}
                        </h5>
                    </div>
                    <div class="input-group mb-3 col-12">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input name="user_info[delete_image]" type="checkbox" value="1" />
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
                                    {{ checked(old('user_info.show_picture',
                                        $data['user']->user_info->show_picture ?? '')) }}
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
                <div class="col-12 mb-4">
                    <div class=" col editor-container editor-container_classic-editor" id="editor-container">
                        <div class="editor-container__editor">
                    <textarea name="user_info[about]" id="textarea" placeholder="Content" class="form-control text-black">
                    </textarea>
                        </div>
                    </div>
                </div>
                <script type="importmap">
                    {
                        "imports": {
                            "ckeditor5": "/js/ckeditor5/ckeditor5.js",
                            "ckeditor5/": "/js/ckeditor5/"
                        }
                    }
                </script>
                <script>
                    var textarea = @json($data['user']->user_info->about ?? '');
                    var textarea1 = @json($data['textarea1'] ?? '');
                </script>
                <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
            </div>
        </div>
        <div class="row border border-primary rounded border-3 mt-lg-2 p-lg-2">
            <div class="col-12 mt-2 mb-2">
                <h4>
                    Membership type & details
                </h4>
            </div>
            <div class="col-12 mt-2 mb-2">
                <p>Member status is for all regular members, and Office is for office administrators.</p>
                <p>
                    <i>Note: this section will manage membership date range and member seniority when we
                        are ready to do so.</i>
                </p>
                @foreach ($data['membership'] as $m)
                    <div class="input-group mb-3 col-12">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input name="user_membership[membership_type]" type="radio" value="{{$m}}"
                                    {{ checked($m == ($data['user']->membership->membership_type ?? 'Member') ) }} />
                            </div>
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                               value="{{$m}}" size="40" readonly />
                    </div>
                @endforeach
                <h5>Admin notes:</h5>

                <textarea name="user_membership[admin_notes]" id="membership_admin_notes" class="form-control">
                    {{ old('membership.admin_notes', $data['user']->membership->admin_notes ?? '') }}
                </textarea>


            </div>
        </div>
        <div class="row border border-primary rounded border-3 mt-lg-2 p-lg-2">
            <div class="col-12 mt-2 mb-2">
                <h4>User website admin access roles </h4>
            </div>
            <div class="col-12 mt-2 mb-2 pb-3">
                <p>Use this section to grant access to members for managing content.</p>
                <ul class="list-group">
                    <li class="list-group-item">A member is 'member' by default, and just has access to login.</li>
                    <li class="list-group-item">A writer is a member who can update content in sections of the site.
                        Committee privileges are not a part of this. </li>
                    <li class="list-group-item">An access level of 'office' allows for office staff to manage users.</li>
                    <li class="list-group-item">Super-admin access is for full do everything access.</li>
                </ul>
            </div>
            @foreach ($data['roles'] as $role)
                <div class="col-12 mb-1">
                    <div class="input-group">
                        <div class="input-group-prepend mr-2 ">
                            <div class="input-group-text">
                                <input name="user_roles[]" type="checkbox" value="{{$role->name}}"
                                    {{ checked(array_key_exists($role->name, $data['user_roles'])) }}
                                />
                            </div>
                            <strong class="pl-lg-2">{{$role->name}}</strong>
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
        <div class="row border border-primary rounded border-3 mt-lg-2 p-lg-2">
            <div class="col-12 mt-2 mb-2">
                <h4>
                    {{ $data['user']->is_banned == 1 ? "Remove suspension for" : "Suspend" }} {{$data['user']->name}}
                </h4>
            </div>
            <div class="input-group mb-2 col-12">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input name="user[is_banned]" type="hidden" value="0" />
                        <input name="user[is_banned]" type="checkbox"
                               value="1"
                               {{ checked(old('user.is_banned', $data['user']->is_banned ?? '')) }} />
                    </div>
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox"
                       value="{{$data['user']->is_banned == 1 ? "Uncheck to remove suspension for"
                                        : "Check to suspend"}} {{$data['user']->name}}"
                       size="40" readonly>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
            <div class="col-sm">
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
