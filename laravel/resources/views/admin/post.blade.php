<?php
$post = $data['post'];
$topics = $data['topics'];
?>
@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' post ' . ($data["action"] == 'Edit' ? $post->name : '') ])
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
    <h3>  <a href="{{ route('posts_list') }}"> <i class="far fa-arrow-alt-circle-left"></i> List of posts</a>  </h3>
    <form method="post" name="post" action="{{ url()->current() }}" enctype="multipart/form-data" class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Title</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="post[title]" value="{{ old('post.title', $post->title)}}" size="80" required/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-2">
                    <h4>Summary</h4>
                </div>
                <div class="col-lg-10">
                    <textarea name="post[description]" id="post-description" placeholder="Summary content" class="form-control">{{old('post.description', $post->description)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3"> <h4>Select topics for this content</h4>&nbsp;</div>
        <div class="row mt-lg-1"> &nbsp;
            <div class="form-group">
            @foreach ($topics as $topic)
                <div class="form-check">
                    <input class="form-check-input" name="post[topic_id][]" type="checkbox" value="{{$topic->id}}" id="{{$topic->name}}{{$topic->id}}"
                        @if ( in_array($topic->id, $data['assignedTopics']) )
                            checked
                        @endif
                    />
                    <label class="form-check-label" for="{{$topic->name}}{{$topic->id}}">
                        {{$topic->name}}
                    </label>
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
                    <textarea name="post[content]" id="post-content" placeholder="Content" class="form-control">{{old('post.content', $post->content)}}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3"> &nbsp;</div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-6 col-sm-3 align-middle"><h4>Access Level for content</h4></div>
                    <div class="col-6 col-sm-3">
                        <div class="form-group">
                            {{ select_options($data['access_levels'], old('post.access_level', $post->access_level), ['name' => 'post[access_level]', 'class' => 'form-control', 'placeholder' => 'Access Level']) }}
                        </div>
                    </div>
                    <div class="col-6 col-sm-3"></div>
                    <div class="col-6 col-sm-3"></div>
                    <!-- Force next columns to break to new line -->
                    <div class="w-100"></div>
                    <div class="col-12">&nbsp;</div>
                    <div class="col-6 col-sm-3"><h4>Sort Order</h4></div>
                    <div class="col-6 col-sm-3">
                        <input type="text" class="form-control"  id="validationCustom02" placeholder="e.g.: 1000, 2000" name="post[sort_order]" value="{{old('post.sort_order',$post->sort_order)}}" size="30" required/>
                        <p>e.g.: 1000, 2000</p>
                    </div>
                    <div class="invalid-feedback">
                        Please add a numeric sort order {{ @$errors->get('post.sort_order')[0] }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="col-lg-2"><h4>Status</h4></div>
                <div class="col-sm">
                    <label>
                        <input name="post[in_menu]" type="hidden" value="0" />
                        <input name="post[in_menu]" type="checkbox" value="1" {{ checked(old('post.in_menu',$post->in_menu)) }} /> In Menu
                    </label>
                </div>
                <div class="col-sm">

                    <label>
                        <input name="post[allow_comments]" type="hidden" value="0" />
                        <input name="post[allow_comments]" type="checkbox" value="1" {{ checked(old('post.allow_comments', $post->allow_comments)) }} /> Allow Comments
                    </label>
                </div>
                <div class="col-sm">

                    <label>
                         <input name="post[live]" type="hidden" value="0" />
                         <input name="post[live]" type="checkbox" value="1" {{ checked( old('post.live', $post->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3"> &nbsp;</div>

        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Tags</h4></div>
                <div class="col-lg-10">
                    <label><input type="text" name="tags" value="<?php echo htmlentities(old('tags', join(', ', $post->tagNames()))); ?>"size="40" />
                        <br />Add tags related to post, comma separated.</label>
                </div>
            </div>
        </div>

        <div class="row mt-lg-3"> &nbsp;</div>

        <div class="row mb-lg-5">
            <div class="col-sm">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>

         <div class="col-sm"> &nbsp;</div>

    @if ($data['action'] == 'Edit')
         <div class="col-sm" style="float:right">
             <form name="delete" method="POST" action="{{route('post_destroy')}}">
                 {!! csrf_field() !!}
                 {!! method_field('DELETE') !!}
                <i class="far fa-trash-alt fa-2x"></i>
                <input type="hidden" name="id[]" value="{{ $post->id }}">
                <input class="btn btn-outline-danger" type="submit" value="Delete">
            </form>
         </div>
    @endif
</div>
    @if ( $data['action'] == 'Edit')
        <div class="row mt-lg-3 mb-lg-3"> &nbsp;post added by {{$post->user->name}}</div>
    @endif
@endsection
