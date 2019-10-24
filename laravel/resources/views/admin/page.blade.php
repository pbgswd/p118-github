<?php
$page = $data['page'];
$topics = $data['topics'];
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' Page ' . ($data["action"] == 'Edit' ? $page->name : '') ])
@section('content')
    <script>
        tinymce.init({
            mode: 'textareas',
            height: 200,
            width:800,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ]
        });
    </script>

<div class="container">
    <h3>  <a href="{{ route('pages_list') }}"> <i class="far fa-arrow-alt-circle-left"></i> List of pages</a>  </h3>
    <form method="post" name="page" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        <input type="hidden" name="page[id]" value="{{ $page['id'] }}">
        <input type="hidden" name="page[user_id]" value="{{ $page['user_id'] }}">
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Title</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="page[title]" value="{{ old('page.title', $page->title)}}" size="80" required/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Summary</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="page[description]" id="page-description" placeholder="Summary content" class="form-control">{{old('page.description', $page->description)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:3em;"> <h4>Select topics for this content</h4>&nbsp;</div>

        <div class="row" style="margin-top:1em;"> &nbsp;
            <div class="form-group">
            @foreach ($topics as $topic)
                <div class="form-check">
                    <input class="form-check-input" name="page[topic_id][]" type="checkbox" value="{{$topic->id}}" id="{{$topic->name}}{{$topic->id}}" />

                    <label class="form-check-label" for="{{$topic->name}}{{$topic->id}}">
                        {{$topic->name}}
                    </label><br />
                </div>

            @endforeach
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Content</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="page[content]" id="page-content" placeholder="Content" class="form-control">{{old('page.content', $page->content)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>
        <div class="row" style="border-width:6px; !important;">
            @if( $page->image )
                <div class="col-md-6">
                    <div class="col">
                        <h4>
                            <i class="far fa-images"></i>
                            Image preview
                        </h4>

                        <h5>Currently: {{ $page->image }}</h5>
                        <img src="{{ asset('storage/'.$page->image) }}" />
                    </div>
                    <div class="col" style="margin-top: 3em;">
                        <input type="hidden"  name="page[image]" value="{{$page->image}}" />
                        <label>
                            <input name="page[delete_image]" type="checkbox" value="1" /> Check to delete image
                        </label>
                    </div>
                </div>
            @else
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputFile">
                            <i class="fas fa-cloud-upload-alt fa-2x"></i>
                            File input
                        </label>
                        <input type="file" id="inputFile" name="image" />
                        <p class="help-block">
                            Upload image for page.
                        </p>
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
                        <input type="text" class="form-control"  placeholder="Access Level: public, members, executive" name="page[access_level]" value="{{ old('page.access_level', $page->access_level)}}" size="30" required/>
                        <p>Access Level: public, members, executive</p>
                    </div>
                    <div class="col-6 col-sm-3"></div>
                    <div class="col-6 col-sm-3"></div>
                    <!-- Force next columns to break to new line -->
                    <div class="w-100"></div>
                    <div class="col-12">&nbsp;</div>
                    <div class="col-6 col-sm-3"><h4>Sort Order</h4></div>
                    <div class="col-6 col-sm-3">
                        <input type="text" class="form-control"  id="validationCustom02" placeholder="e.g.: 1000, 2000" name="page[sort_order]" value="{{old('page.sort_order',$page->sort_order)}}" size="30" required/>
                        <p>e.g.: 1000, 2000</p>
                    </div>
                    <div class="invalid-feedback">
                        Please add a numeric sort order {{ @$errors->get('page.sort_order')[0] }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="col-lg-2"><h4>Status</h4></div>
                <div class="col-sm">
                    <label>
                        <input name="page[in_menu]" type="hidden" value="0" />
                        <input name="page[in_menu]" type="checkbox" value="1" {{ checked(old('page.in_menu',$page->in_menu)) }} /> In Menu
                    </label>
                </div>
                <div class="col-sm">

                    <label>
                        <input name="page[allow_comments]" type="hidden" value="0" />
                        <input name="page[allow_comments]" type="checkbox" value="1" {{ checked(old('page.allow_comments', $page->allow_comments)) }} /> Allow Comments
                    </label>
                </div>
                <div class="col-sm">

                    <label>
                         <input name="page[live]" type="hidden" value="0" />
                         <input name="page[live]" type="checkbox" value="1" {{ checked( old('page.live', $page->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:30px;"> &nbsp;</div>

        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Tags</h4></div>
                <div class="col-lg-10">
                    <label><input type="text" name="tags" value="<?php echo htmlentities(old('tags', join(', ', $page->tagNames()))); ?>"size="40" />
                        <br />Add tags related to page, comma separated.</label>
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
             <form name="delete" method="POST" action="{{route('page_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $page->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
</div>
    <div class="row" style="margin-top:3em; margin-bottom: 3em;"> &nbsp;Page added by {{$page->user->name}}</div>
</div>
@endsection
