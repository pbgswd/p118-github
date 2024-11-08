@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paint-brush"></i>', 'title' => 'Page For Drag'])
@section('content')
<script>
    console.log('inside admin-blank.blade the template file');
</script>

<div class="row my-5">
    <div class="col-12">
        <a href="{{ route('blank') }}">Blank Page</a> | <a href="{{ route('developer') }}">Resources Page</a>
    </div>
</div>


<div class="row border rounded mt-6 mb-3 p-3">
    <div class="col-12">
        <h2>Todo: drag and drop  file upload</h2>
    </div>
    <div class="col-12">
        <form method="post" id="fileupload" action="">
            @CSRF
            <div class="form-group">
                <label for="exampleInputFile">
                    <i class="fas fa-cloud-upload-alt fa-2x"></i>
                    Add File(s)
                </label>
                <input type="file" id="inputFile" name="attachments[]" multiple />
            </div>
            <button type="button" class="btn btn-primary m-2">submit</button>
        </form>
    </div>
    <div class="col-12">
        <a href="https://safrazik.github.io/vue-file-agent/?ref=madewithvuejs.com#installation">
            https://safrazik.github.io/vue-file-agent/?ref=madewithvuejs.com#installation
        </a>

        https://codepen.io/safrazik/pen/BaBpYme
    </div>
</div>
@endsection
