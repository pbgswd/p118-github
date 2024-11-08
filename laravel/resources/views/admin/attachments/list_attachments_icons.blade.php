@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paperclip"></i> <i class="far fa-image"></i>',
'title' => ' List Attachements and Images'])
@section('content')

    <div class="container my-6">
        <h1 x-data="{ message: 'I ❤️ Alpine' }" x-text="message"></h1>
        <div x-data="imageInserter()">
            <div class="row my-5">
                <div class="col">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Media Library
                    </button>
                </div>
                <div class="col">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#urlModal">
                        Insert from URL
                    </button>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        Upload and insert image
                    </button>
                </div>
            </div>
            <div class="row mt-6 pt-6 mb-6">
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-2" id="exampleModalLabel">Media Library</h1>
                                <button type="button" class="btn-close m-1" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row m-2 p-2 border border-secondary">Filter by date, type, search</div>
                                <div class="row justify-content-center">

                                    <livewire:admin.endless-media />

                                </div>
                                <noscript>
                                    <div class="row mt-2">
                                        <div class="list-group mt-2">
                                            <ul class="pagination justify-content-center">

                                            </ul>
                                        </div>
                                    </div>
                                </noscript>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <!-- Modal for URL input -->
            <div class="modal fade" id="urlModal" tabindex="-1" aria-labelledby="urlModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="urlModalLabel">Insert Image from URL</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5>Insert image from URL into the textarea.</h5>
                            <form @submit.prevent="insertUrl">
                                <div class="mb-3">
                                    <label for="exampleInputURL" class="form-label">Insert URL</label>
                                    <input type="text" class="form-control" name="imageUrl" id="exampleInputURL" x-model="imageUrl" aria-describedby="urlHelp">
                                    <div id="urlHelp" class="form-text">Use a fully qualified web address (https://example.com/image.jpg)</div>
                                </div>
                                <button type="submit" class="btn btn-outline-secondary">Insert</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal for URL input -->
            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="urlModalLabel">Upload Image and Insert</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row my-3">
                                (Select a section to save it to)
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="public">Public</option>
                                    <option value="pages">Pages</option>
                                    <option value="post">Posts</option>
                                </select>
                            </div>
                            <div class="row my-3">
                                <label for="formFileMultiple" class="form-label">Upload files to insert</label>
                                <input class="form-control mb-3" type="file" id="formFileMultiple" @change="uploadImage($event)" multiple>

                                <button type="submit" class="btn btn-outline-secondary">** Insert</button>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-5">
            <h4 class="my-4">Content</h4>
            <div class="form-group">

                <div class="editor-container editor-container_classic-editor" id="editor-container">
                    <div class="editor-container__editor">
                        <textarea x-model="htmlContent" name="data[content]" id="textarea" placeholder="Content"
                                  class="form-control text-black" rows="5">
                        </textarea>
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
                    var textarea = @json($data['content'] ?? '');
                    var textarea1 = @json($data['textarea1'] ?? '');
                </script>
                <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
            </div>
        </div>
    </div>
@endsection
