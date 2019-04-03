@extends('layouts.dashboard')
@section('content')
<div class="container">
    <?php
        $topic = $data['topic'];
    ?>

    <h1 class="page-header"><i class="fas fa-edit"></i> {{ $data['action'] }} Topic
        @if ($data['action'] == 'Edit')
            {{ $topic->name }}
        @endif
    </h1>
        <h3>  <a href="{{ route('topics_list') }}"> <i class="far fa-arrow-alt-circle-left"></i> List of topics</a>  </h3>


    <form method="post" name="topics" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        <input type="hidden" name="topic[id]" value="{{ $topic['id'] }}">
        {!! csrf_field() !!}
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Title</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="topic[name]" value="{{ old('topic.name', $topic->name)}}" size="80" required/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Summary</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="topic[description]" placeholder="Summary content" class="form-control" cols="100" rows="6">{{old('topic.description', $topic->description)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row border border-info p-5 rounded-lg" style="border-width:6px; !important;">

            @if( !$topic->image )
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputFile">
                            <i class="fas fa-cloud-upload-alt fa-2x"></i>
                            File input
                        </label>
                        <input type="file" id="inputFile" name="topic[image]" />
                        <p class="help-block">
                            Upload image for topic.
                        </p>
                    </div>
                </div>
            @else

            <div class="col-md-6">
                <div class="col">
                    <h4>
                        <i class="far fa-images"></i>
                        Image preview
                    </h4>

                    @if( $topic->image  )
                        <input type="hidden"  name="topic[image]" value="{{$topic->image}}" />
                        <h5>Currently: {{ $topic->image }}</h5>
                        <img src="/storage/{{$topic->image}}" />
                </div>

                <div class="col" style="margin-top: 3em;">
                    <label>
                        <input name="topic[delete_image]" type="checkbox" value="1" /> Check to delete image
                    </label>
                    @else
                        <h5><i>No image uploaded</i></h5>
                    @endif
                </div>
            </div>
            @endif
        </div>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6 col-sm-3 align-middle"><h4>Access Level</h4></div>
                    <div class="col-6 col-sm-3">
                        <input type="text" class="form-control"  placeholder="Access Level: public, members, executive" name="topic[access_level]" value="{{ old('topic.access_level', $topic->access_level)}}" size="30" required/>
                        <p>Access Level: public, members, executive</p>
                    </div>
                    <div class="col-6 col-sm-3"></div><div class="col-6 col-sm-3"></div>
                    <!-- Force next columns to break to new line -->
                    <div class="w-100"></div>
                    <div class="col-12">&nbsp;</div>
                    <div class="col-6 col-sm-3"><h4>Sort Order</h4></div>
                    <div class="col-6 col-sm-3">
                        <input type="text" class="form-control"  id="validationCustom02" placeholder="e.g.: 1000, 2000" name="topic[sort_order]" value="{{old('topic.sort_order',$topic->sort_order)}}" size="30" required/>
                        <p>e.g.: 1000, 2000</p>
                    </div>
                    <div class="invalid-feedback">
                        Please add a numeric sort order {{ @$errors->get('topic.sort_order')[0] }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-sm">

                    <label>
                        <input name="topic[in_menu]" type="hidden" value="0" />
                        <input name="topic[in_menu]" type="checkbox" value="1" {{ checked(old('topic.in_menu',$topic->in_menu)) }} /> In Menu
                    </label>
                </div>
                <div class="col-sm">

                    <label>
                        <input name="topic[allow_comments]" type="hidden" value="0" />
                        <input name="topic[allow_comments]" type="checkbox" value="1" {{ checked(old('topic.allow_comments', $topic->allow_comments)) }} /> Allow Comments
                    </label>
                </div>
                <div class="col-sm">

                    <label>
                         <input name="topic[live]" type="hidden" value="0" />
                         <input name="topic[live]" type="checkbox" value="1" {{ checked( old('topic.live', $topic->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>

         <div class="col-sm"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
         <div class="col-sm" style="float:right">
             <form name="delete" method="POST" action="{{route('topic_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $topic->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
    <div class="row" style="margin-top:100px;"> &nbsp;</div>
</div>
@endsection
