@extends('layouts.dashboard')
@section('content')
<script>
    console.log('inside admin-blank.blade the template file');
</script>
<div class="row mt-6 mb-6" style="height: 100px">
    <div class="col">
        <h1>Page For Development</h1>
    </div>
</div>



<div class="row mb-6">

        <div class="col-12">
            <div class="d-block d-md-none mb-4" id="textarea_sm_container">
                <div class="mb-5">
                    <textarea name="post[content]" id="textarea-sm" placeholder="Content" class="form-control">
                        {{$data['textarea']}}
                    </textarea>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="d-none d-md-block col editor-container editor-container_classic-editor" id="editor-container">
                <div class="editor-container__editor">
                    <textarea name="post[content]" id="textarea" placeholder="Content" class="form-control text-black">
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
        var textarea = @json($data['textarea'] ?? '');
        var textarea1 = @json($data['textarea1'] ?? '');
    </script>
    <script type="module" src="{{mix('js/ckeditor5/ck_main_admin.js')}}"></script>




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
