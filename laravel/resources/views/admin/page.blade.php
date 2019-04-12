@extends('layouts.dashboard',  ['title' => ' <i class="fas fa-edit"></i>' . $data["action"] . ' Topic ' . ($data["action"] == 'Edit' ? $topic->name : '') ])
@section('content')
<div class="container">
    <?php
        $topic = $data['topic'];
    ?>

    <h1 class="page-header">{{ $data['action'] }} Page -- to be developed
        @if ($data['action'] == 'Edit')
            Edit {{ $topic->name }}
        @endif
    </h1>

    <form method="post" name="posts" action="{{ url()->current() }}">
        <input type="hidden" name="topic[id]" value="{{ $topic['id'] }}">
        {!! csrf_field() !!}

        <div class="row">
            <div class="form-group">
                <div class="col-lg-2"><h4>Title</h4></div>
                <div class="col-lg-10">
                    <input type="text" class="form-control"  placeholder="Title" name="topic[name]" value="{{ old('topic.name', $topic->name)}}" size="40" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <h4>Summary</h4>
                <textarea name="topic[description]" placeholder="Summary content" class="form-control" cols="100" rows="6">{{old('topic.description', $topic->description)}}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <h4>Content</h4>
                <textarea name="topic[content]" placeholder="Content" class="form-control" cols="100" rows="10">{{old('topic.content', $topic->content)}}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <input type="file" id="exampleInputFile" name="topic[image]">
                    <p class="help-block">Example block-level help text here.</p>
                </div>
            </div>
            <div class="col-md-6">
                <h4>Image preview</h4>
            </div>
        </div>

        <div class="col-md-2">
            <h4>Topic type </h4>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="radio">
                    <label>
                        <input type="radio" name="topic[is_page]" value="0" {{ checked( old('topic.is_page', $topic->is_page), false) }}>
                        Topic (subject heading for posts)
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="radio">
                    <label>
                        <input type="radio" name="topic[is_page]"  value="1" {{ checked( old('topic.is_page', $topic->is_page), true) }}>
                        Single Page
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <h4>Sort Order</h4>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control"  placeholder="e.g.: 1000, 2000" name="topic[sort_order]" value="{{old('topic.sort_order',$topic->sort_order)}}" size="8" />
            </div>
        </div>

        <div class="row" style="margin-top:30px;"> &nbsp;</div>

        <div class="col-md-4">
            <input name="topic[in_menu]" type="hidden" value="0" {{ checked(old('topic.in_menu',$topic->in_menu)) }} /></label>
            <label>In Menu: <input name="topic[in_menu]" type="checkbox" value="1" {{ checked(old('topic.in_menu',$topic->in_menu)) }} /></label>
        </div>

        <div class="col-md-4">
            <input name="topic[allow_comments]" type="hidden" value="0" {{ checked( old('topic.allow_comments', $topic->allow_comments) ) }} /></label>
            <label>Allow Comments: <input name="topic[allow_comments]" type="checkbox" value="1" {{ checked(old('topic.allow_comments', $topic->allow_comments)) }} /></label>
        </div>

        <div class="col-md-4">
            <input name="topic[live]" type="hidden" value="0" />
            <label>Check now to make Live: <input name="topic[live]" type="checkbox" value="1" {{ checked( old('topic.live', $topic->live)) }} /></label>
        </div>

        <div class="row" style="margin-top:60px;"> &nbsp;</div>


        <div class="col-md-2">
            <input class="btn btn-primary" type="submit" value="{{ $data['action'] }}" />
        </div>

    </form>

    <div class="col-md-8"> &nbsp;</div>
    @if ($data['action'] == 'Edit')
    <div class="col-md-2">
        <form method="post" name="topic" action="{{route('topic_delete')}}">
            <input type="hidden" name="id[]" value="{{ $topic->id }}">
            <input class="btn btn-warning" type="submit" value="Delete">
        </form>
    </div>
    @endif
    <div class="row" style="margin-top:30px;"> &nbsp;</div>

</div>
@endsection
