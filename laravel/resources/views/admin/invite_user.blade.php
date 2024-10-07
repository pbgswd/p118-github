<?php
$invite = $data['invite'];
$roles = $data['roles'];
?>
@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-envelope-square"></i>', 'title' =>
    ' Invite Member to Website'])
@section('content')
<div class='container mt-lg-4'>
<h3>Note: In the future, there will be a 48 hour expiry time on invitations.</h3>
        <form method="post" name="invite_user" action="{{ url()->current() }}"
              enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
            <div class="col-12 input-group mt-lg-5 mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text mb-2" id="inputGroup-sizing-default">Name</span>
                    <input type="text" class="form-control"  placeholder="Name" name="invite[name]"
                           value="{{ old('invite.name', $invite->name ?? '')}}" size="80" required />
                </div>
            </div>
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text mb-2" id="inputGroup-sizing-default">Email</span>
                    <input type="text" class="form-control"  placeholder="Email" name="invite[email]"
                           value="{{ old('invite.email', $invite->email ?? '')}}" size="80" required/>
                </div>
            </div>


            <div class="row mt-lg-5 mb-lg-5">
                <div class="col-12">
                    <h4>Membership Status, type ({{$data['invite']['membership_type']}})</h4>
                    @foreach ($data['membership'] as $m)
                        <div class="input-group mb-3 col-12">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input name="invite[membership_type]" type="radio" value="{{$m}}"
                                        {{ checked($m == $data['invite']['membership_type']) }} />
                                </div>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox"
                                   value="{{$m}}" size="40" readonly />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-12">
                        <h4>Message (optional)</h4>
                    </div>
                        <div class="col-12">
                            <div class="col-12 mb-4">
                                <div class=" col editor-container editor-container_classic-editor" id="editor-container">
                                    <div class="editor-container__editor">
                                    <textarea name="invite[message]" id="textarea" placeholder="Content"
                                              class="form-control text-black">
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
                                var textarea = @json($invite->message ?? '');
                                var textarea1 = @json($data['textarea1'] ?? '');
                            </script>
                            <script type="module" src="{{mix('js/ckeditor5/ck_main_admin.js')}}"></script>
                        </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 mt-lg-2 p-2">
                    <h4>User website roles (admin access privileges)</h4>
                    @foreach ($data['roles'] as $role)
                        <div class="input-group mb-6 col-12">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input name="invite[role]" type="radio" value="{{$role->name}}"
                                        {{ checked(array_key_exists($role->name, $invite->role)) }} />
                                </div>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox"
                                   value="{{$role->name}} (@foreach ($role->permissions as $p){{ $p->name }}, @endforeach)"
                                   size="40" readonly />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row mt-lg-5 mb-lg-5">
                <div class="col-sm">
                    <i class="fas fa-edit fa-2x"></i>
                    <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
                </div>
        </form>
        <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
        @hasanyrole('super-admin|admin')
        <div class="col-sm" style="float:right">
            <form name="delete" method="POST" action="{{route('user_destroy')}}">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $user->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
        </div>
        @endhasanyrole
    @endif
</div>
@endsection
