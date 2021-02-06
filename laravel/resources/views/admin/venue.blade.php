<?php
$venue = $data['venue'];
$all_agreements = $data['all_agreements'];
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"]
. ' Venue ' . ($data["action"] == 'Edit' ? $venue->name : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <h3>
                <a href="{{ route('venues_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    List of venues
                </a>
            </h3>
        </div>
        @if($data['action'] == 'Edit')
            <div class="col-12 col-md-6 text-md-right">
                <a href="{{route('venue', $data['venue']->slug)}}"
                   title="View {{$data['venue']->name}}">
                    <i class="fas fa-eye"></i> View on website
                </a>
            </div>
        @endif
    </div>

    <form method="post" name="venue" action="{{ url()->current() }}"
          enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-2"><h4>Name</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"
                           placeholder="Name" name="venue[name]"
                           value="{{ old('venue.name', $venue->name)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Description</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="venue[description]" id="venue-description"
                              placeholder="Summary content" class="form-control">
                        {{old('venue.description', $venue->description)}}
                    </textarea>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="form-group">
                <div class="col-lg-8"><h4>Venue Website Link</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"
                           placeholder="Website Address - http://...." name="venue[url]"
                           value="{{ old('venue.url', $venue->url)}}" size="80" />
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-md-6">
                <div class="row">
                     <div class="col-6 col-sm-3"></div>
                    <div class="col-6 col-sm-3"></div>
                    <!-- Force next columns to break to new line -->
                    <div class="w-100"></div>
                    <div class="col-12">&nbsp;</div>
                    <div class="col-6 col-sm-3"><h4>Sort Order</h4></div>
                    <div class="col-6 col-sm-3">
                        <input type="text" class="form-control"  id="validationCustom02"
                               placeholder="e.g.: 1000, 2000" name="venue[sort_order]"
                               value="{{old('venue.sort_order',$venue->sort_order)}}" size="30" required/>
                        <p>e.g.: 1000, 2000</p>
                    </div>
                    <div class="invalid-feedback">
                        Please add a numeric sort order {{ @$errors->get('venue.sort_order')[0] }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-lg-2"><h4>Status</h4></div>
                <div class="col-sm">
                    <label>
                        <input name="venue[in_menu]" type="hidden" value="0" />
                        <input name="venue[in_menu]" type="checkbox" value="1"
                            {{ checked(old('venue.in_menu',$venue->in_menu)) }} /> In Menu
                    </label>
                </div>
                <div class="col-sm">
                    <label>
                         <input name="venue[live]" type="hidden" value="0" />
                         <input name="venue[live]" type="checkbox" value="1"
                             {{ checked( old('venue.live', $venue->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row border border-dark m-t-5 mb-lg-5">
        @if ($data['action'] == 'Edit')
            <div class="col-5 m-1 border border-dark">
                Agreements attached to {{$venue->name}}
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">From</th>
                        <th scope="col">Until</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($venue->member_agreements as $va)
                            <tr>
                                <th scope="row">
                                    <input type="checkbox" name="id[]" value="{{$va->id}}" />
                                </th>
                                <td>
                                    <a title="{{$va->title}}" href="{{ route('agreement_edit', $va->id) }}">
                                        {{ $va->title }}
                                    </a>
                                    @if(\Carbon\Carbon::parse($va->until)->isPast())
                                        <i>(Not current)</i>
                                    @endif
                                </td>
                                <td>{{$va->from->format('F j Y')}}</td>
                                <td>{{$va->until->format('F j Y')}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td> <i class="far fa-trash-alt fa"></i></td>
                            <td colspan="3">Check to remove from Venue</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
            <div class="col-5 m-1 border border-dark">
                <div class="form-group">
                    <label for="exampleFormControlSelect2">List of all agreements not currently attached to
                        {{$venue->name}}. Select and submit to attach to venue</label>
                    <select multiple class="form-control" name="all_agreements[]" id="agreements" size="20">
                        @foreach($all_agreements as $agr)
                            <option value="{{$agr->id}}">{{$agr->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
    <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
         <div class="col-sm" style="float:right">
             <form name="delete" method="POST" action="{{route('venue_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $venue->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
    <div class="row mt-lg-5"> &nbsp;</div>
</div>
@endsection
