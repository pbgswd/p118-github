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
<div class="row mt-6 mb-6">
    <div class="col-12">
        <a href="{{route('admin_messages')}}">List  Messages</a>   |
        <a href="{{route('admin_message_create')}}">Create Messages</a>
    </div>
</div>
<hr />
<div class="row mt-6 mb-6">
    <div class="col-12">
        <h1>some tailwind</h1>
    </div>
    <div class="col-12">




        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

      <script>
          body{
              padding: 10rem;
              background-color: #00283f;
          }

          #FileUpload.active {
              // When files dragged over
              // @apply shadow-outline-blue border-blue-300;
              box-shadow: 0 0 0 3px rgba(164, 202, 254, 0.45);
              border-color: #a4cafe;
          }
      </script>


        <div class="flex flex-col flex-grow mb-3">
            <div x-data="{ files: null }" id="FileUpload" class="block w-full py-2 px-3 relative bg-white appearance-none border-2 border-gray-300 border-solid rounded-md hover:shadow-outline-gray">
                <input type="file" multiple
                       class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                       x-on:change="files = $event.target.files; console.log($event.target.files);"
                       x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')" x-on:drop="$el.classList.remove('active')"
                >
                <template x-if="files !== null">
                    <div class="flex flex-col space-y-1">
                        <template x-for="(_,index) in Array.from({ length: files.length })">
                            <div class="flex flex-row items-center space-x-2">
                                <template x-if="files[index].type.includes('audio/')"><i class="far fa-file-audio fa-fw"></i></template>
                                <template x-if="files[index].type.includes('application/')"><i class="far fa-file-alt fa-fw"></i></template>
                                <template x-if="files[index].type.includes('image/')"><i class="far fa-file-image fa-fw"></i></template>
                                <template x-if="files[index].type.includes('video/')"><i class="far fa-file-video fa-fw"></i></template>
                                <span class="font-medium text-gray-900" x-text="files[index].name">Uploading</span>
                                <span class="text-xs self-end text-gray-500" x-text="filesize(files[index].size)">...</span>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="files === null">
                    <div class="flex flex-col space-y-2 items-center justify-center">
                        <i class="fas fa-cloud-upload-alt fa-3x text-currentColor"></i>
                        <p class="text-gray-700">Drag your files here or click in this area.</p>
                        <a href="javascript:void(0)" class="flex items-center mx-auto py-2 px-4 text-white text-center font-medium border border-transparent rounded-md outline-none bg-red-700">Select a file</a>
                    </div>
                </template>
            </div>
        </div>














    </div>
</div>


<div class="row">


<div class="mt-6 pt-6" id="anotherapp">
    <form method="post" action="">
        @CSRF
    <textarea v-model="deckDescription" id="description" name="description" class="m-3 pt-6"></textarea>
        <button type="button" class="btn btn-primary m-2">Create</button>
    </form>
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
    <div class="row border rounded border-2 mt-6 mb-3 p-3">
        <h1>Here  is some Vue stuff</h1> <br />
        <br />
        <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

        <script>
            import { createApp } from 'vue'

            createApp({
                data() {
                    return {
                        count: 0
                    }
                }
            }).mount('#app')

            export default {
                props: ['count'],
                // Other Vue component options
            };

        </script>
       ## <div id="app" v-pre:"count"></div>##


    </div>


</div>
@endsection
