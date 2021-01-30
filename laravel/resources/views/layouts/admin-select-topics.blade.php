<div class="col-12 mt-4 mb-2">
    <h4>Select topics for this content</h4>
</div>
<div class="col-12 col-md-8 mt-1 mb-2">
    @foreach ($data['topics'] as $topic)
        <div class="form-check form-check-inline ml-1 mr-1 mt-2 mb-2">
            <input class="form-check-input" name="post[topic_id][]" type="checkbox" value="{{$topic->id}}"
                   id="{{$topic->name}}{{$topic->id}}"
                {{in_array($topic->id, $data['assignedTopics']) ? 'checked':''}}/>
            <label class="form-check-label" for="{{$topic->name}}{{$topic->id}}">
                {{$topic->name}}
            </label>
        </div>
    @endforeach
</div>
