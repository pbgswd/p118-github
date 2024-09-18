@extends('layouts.dashboard',  ['title' => '<i class="fas fa-paperclip"></i> <i class="far fa-image"></i> List Attachements and Images'])
@section('content')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('imageInserter', () => ({
                imageUrl: '',
                insertImage(imgHtml) {
                    tinymce.get('pageTextarea').execCommand('mceInsertContent', false, imgHtml);
                },
                insertUrl() {
                    if (this.imageUrl) {
                        // Create the image HTML string
                        const imgTag = `<img src="${this.imageUrl}" alt="Inserted Image" />`;
                        // Insert the image HTML string into the editor content
                        tinymce.get('pageTextarea').execCommand('mceInsertContent', false, imgTag);
                        // Clear the input field after insertion
                        this.imageUrl = '';
                    } else {
                        alert('Please enter a valid image URL');
                    }
                },
                // insertUploaded() {
                //     // insert image that got uploaded
                //     // I want to insert an image into a textarea from file upload in Laravel using alpine.js. How do I do that?
                //     // https://chatgpt.com/c/7983edb4-7477-4680-92c6-d4cebb5a78f7
                //     if(this.imageUploaded) {
                //         const imgUploaded = `<img src="${this.imageUploaded}" alt="Uploaded Image" />`;
                //         // Insert the image HTML string into the editor content
                //         tinymce.get('pageTextarea').execCommand('mceInsertContent', false, imgUploaded);
                //         this.imageUploaded = '';
                //     } else {
                //         alert('Please upload an image');
                //     }
                // }





        imageUploader() {
            return {
                uploadImage(event) {
                    const file = event.target.files[0];
                    if (!file) {
                        alert('No file selected');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('image', file);

                    // Send the file to the Laravel backend
                    fetch('/attachments_ajax_upload', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.url) {
                                // Insert the image into TinyMCE
                                const imgTag = `<img src="${data.url}" alt="Uploaded Image" />`;
                                tinymce.get('editor').execCommand('mceInsertContent', false, imgTag);
                            } else {
                                alert('Error uploading file');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error uploading file');
                        });
                }
            }
        }

            }));
        });
    </script>

    <div class="container mt-6">
        <div x-data="imageInserter()">
            <div class="row">
                <div class="col">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Media Library
                    </button>
                </div>
                <div class="col">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#urlModal">
                        Insert from URL
                    </button>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
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
                                    @forelse ( $data['attachments'] as $a )
                                        <div class="col-sm-12 col-md-2 m-2 p-4 border border-secondary">
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    @if($a->file_type == 'pdf')
                                                        <i class="fas fa-file-pdf fa-2x"></i>
                                                    @endif
                                                    @if(in_array(strtolower($a->file_type), ['jpg','jpeg','png','gif',]))
                                                        <a href="#" data-bs-toggle="Insert {{$a->file_name}} into content"
                                                        title="Click to insert {{ $a->file_name }} into the content">
                                                            <img src="/storage/{{$a->subfolder}}/{{$a->file}}" class="w-100"
                                                                 @click="insertImage('<img src=\'/storage/{{$a->subfolder}}/{{$a->file}}\' alt=\'{{ $a->file_name }}\' />')"/>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row text-break">
                                                {{$a->access_level}}, {{ $a->file_type}}, <br />
                                                {{$a->file_size}} Kb <br />
                                                <a href="{{ route('admin_attachment_edit', $a->id) }}" title="Edit {{ $a->file_name }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="row">No data</div>
                                    @endforelse
                                </div>
                                <noscript>
                                    <div class="row mt-2">
                                        <div class="list-group mt-2">
                                            <ul class="pagination justify-content-center">
                                                {!! $data['attachments']->links() !!}
                                            </ul>
                                        </div>
                                    </div>
                                </noscript>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                                <button type="submit" class="btn btn-outline-secondary">Submit</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                                    <input class="form-control" type="file" id="formFileMultiple" @change="uploadImage($event)" multiple>
                                    <button type="submit" class="btn btn-outline-secondary">Submit</button>
                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>














        </div>
        <div class="row mb-6">
            <!-- Textarea on the page -->
            <div class=" col-12 mt-3">
                <textarea id="pageTextarea" x-model="htmlContent" name="htmlContent" class="form-control" rows="5"></textarea>
            </div>
        </div>
    </div>
@endsection
