@extends('layouts.dashboard',  ['title' => '<i class="fas fa-users-cog"></i> Admin Dashboard'])
@section('content')
<div class="container">
    <div class="row border border-dark rounded-lg p-3">
        <div id="app"></div>
        @role('super-admin')
            <h3>
                Members with the <strong>super-admin</strong> role can manage users, content, committees,
                and all aspects of the website.
            </h3>
        @endrole
        @role('office')
            <h3>
                Members with the <strong>office</strong> or <strong>super-admin</strong> role can manage users.
            </h3>
        @endrole
        @role('committee')
            <h3>
                Members with the <strong>committee</strong> management  or <strong>super-admin</strong>
                role can manage committee content, and members.
            </h3>
        @endrole
        @role('writer')
            <h3>
                Members with the <strong>writer</strong>  or <strong>super-admin</strong> role can manage the various
                sections of content on the website.
            </h3>
        @endrole
        <h3>
            Use the links in the menu on the left for available sections and the <strong>Search</strong> input
            field above to find records.
        </h3>
    </div>
    <div class="row border border-dark rounded-lg mt-3 p-lg-5 d-block d-md-none d-lg-none">
        @include(('layouts.dashboard-list'))
    </div>
</div>
@endsection

