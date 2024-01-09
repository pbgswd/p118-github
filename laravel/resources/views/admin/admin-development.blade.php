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
<div class="row border rounded mt-6 mb-3 p-3">
<style>
    #profile-pic-demo .drop-help-text {
        display: none;
    }
    #profile-pic-demo .is-drag-over .drop-help-text {
        display: block;
    }
    #profile-pic-demo .profile-pic-upload-block {
        border: 2px dashed transparent;
        padding: 20px;
        padding-top: 0;
    }

    #profile-pic-demo .is-drag-over.profile-pic-upload-block {
        border-color: #AAA;
    }
    #profile-pic-demo .vue-file-agent {
        width: 180px;
        float: left;
        margin: 0 15px 5px 0;
        border: 0;
        box-shadow: none;
    }


</style>


    <script type="text/x-template" id="vue-file-agent-demo">
        <div id="profile-pic-demo" class="bg-light pt-3">
            <VueFileAgent
                class="profile-pic-upload-block"
                ref="profilePicRef"
                :multiple="false"
                :deletable="false"
                :meta="false"
                :compact="true"
                :accept="'image/*'"
                :helpText="'Drag an image file here'"
                :errorText="{
        type: 'Please select an image',
      }"
                v-model="profilePic"
                @select="onSelect($event)"
            >
                <template v-slot:before-outer>
                </template >
                <template v-slot:after-inner>
                    <span title="after-inner" class="btn btn-link btn-sm btn-block">Select image file</span>
                </template >
                <template v-slot:after-outer>
                    <div title="after-outer">
                        <p>Please select an image and click the upload button</p>
                        <div class="drop-help-text">
                            <p class="text-success">Drop the file!</p>
                        </div>
                        <button type="button" class="btn btn-primary" :class="{'disabled': uploaded || !profilePic}" @click="upload()">Upload</button>
                        <button type="button" class="btn" :class="[uploaded ? 'btn-danger' : 'btn-secondary']" v-if="profilePic" @click="removePic()">Remove</button>
                        <div class="clearfix"></div>
                    </div>
                </template >
            </VueFileAgent>
        </div>
    </script>

<script>

    var component = {
        data: function(){
            return {
                name: 'Gapal',
                profilePic: null,
                uploaded: false,
                uploadUrl: 'https://www.mocky.io/v2/5d4fb20b3000005c111099e3',
                uploadHeaders: {},
            }
        },
        methods: {
            removePic: function(){
                var profilePic = this.profilePic;
                this.$refs.profilePicRef.deleteUpload(this.uploadUrl, this.uploadHeaders, [profilePic]);
                this.profilePic = null;
                this.uploaded = false;
            },
            upload: function(){
                var self = this;
                this.$refs.profilePicRef.upload(this.uploadUrl, this.uploadHeaders, [this.profilePic]).then(function(){
                    self.uploaded = true;
                    setTimeout(function(){
                        // self.profilePic.progress(0);
                    }, 500);
                });
            },
            onSelect: function(fileRecords){
                console.log('onSelect', fileRecords);
                this.uploaded = false;
            }
        }
    }

    component.template = '#vue-file-agent-demo';

    Vue.component('vue-file-agent-demo', component);

    new Vue({
        el: '#app'
    });
</script>

    <!-- ----------------------------- -->

    <div class="container py-3">
        <div id="app">

            <h5><a target="_blank" href="https://safrazik.github.io/vue-file-agent">Vue File Agent</a> Playground</h5>

            <hr>

            <vue-file-agent-demo></vue-file-agent-demo>

        </div>
    </div>
</div>
<div class="row border rounded mt-6 mb-3 p-3">
    <div class="col-12">
        <h2>Todo image library, insert into content</h2>
        <a href="https://madewithvuejs.com/laravel-media-manager">
            https://madewithvuejs.com/laravel-media-manager
        </a>
    </div>
</div>
@endsection
