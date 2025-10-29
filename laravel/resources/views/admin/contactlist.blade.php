@extends('layouts.dashboard',  ['title_icon' => ' <i class="fas fa-edit"></i>', 'title' => $data["action"] . ' Employer Contacts ' .
    ($data["action"] == 'Edit' ? $data['contactlist']->title : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row my-4">
        <div class="col-12 col-md-6">
            <h4> edit form page
                <a href="{{ route('contactlist_edit') }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    go to edit page
                </a>
            </h4>
        </div>
        <div class="col-12 col-md-6 text-md-right">
            <h4>
                <a href=""
                   title="View {{$data['contactlist']->title}}">
                    <i class="fas fa-eye"></i> View on website not yet implemented
                </a>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-2">
            <h4>{{$data['contactlist']->title}}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                {{$data['contactlist']->content}}
            </div>
        </div>
        <div class="row mt-3 mb-2 pb-2 pt-2">
            <div class="col-12 col-md-6 text-md-right">
                <h4>Access Level: {{$data['contactlist']->access_level}}</h4>
            </div>
            <div class="col-12 col-md-6 text-md-right">
                <h4>Status: {{$data['contactlist']->live == '1' ? 'live':'off' }}</h4>
            </div>
        </div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col-12">
            <h2>List of Files, later</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <hr />
            <h2>List of Employers</h2>
        </div>
        <div class="col-12 col-md-6">
            <hr />
            <h2>
                <a href="{{route('contactlistdata_create')}}" class="btn btn-primary">
                    Create New Employer Contact
                </a>
            </h2>
        </div>
    </div>
    @foreach($data['contactlistdata'] as $cld)
<hr />
       <h4> {{$cld['name']}}</h4>
        {{$cld['addr1']}}
        {{$cld['addr2']}} <br />
        {{$cld['city']}}
        {{$cld['province']}} {{$cld['country']}} {{$cld['postal_code']}} <br />
        <a href="{{$cld['website']}}" title="{{$cld['name']}}" target="_blank">{{$cld['website']}}</a> <br />
        {{$cld['email']}} <br />
        Contact: {{$cld['contact']}} <br />
        Phone: {{$cld['phone']}} <br />
        Info: <br />
        {{$cld['notes']}} <br /><br />
        Access Level: {{$cld['access_level']}} <br />
        Live? {{$cld['live'] == 1 ? 'yes' : 'no'}}; updated at:{{$cld['updated_at']}}
        <a href="{{$cld['id']}}" class="btn btn-primary">Edit {{$cld['name']}}</a>
        <br />

    @endforeach
</div>
@endsection
