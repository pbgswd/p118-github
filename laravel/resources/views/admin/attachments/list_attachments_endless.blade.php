@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paperclip"></i> <i class="far fa-image"></i>',
'title' => ' List Attachement endless'])
@section('content')
    <h1 x-data="{ message: 'I ❤️ Alpine' }" x-text="message"></h1>

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
                        <div class="row m-2 p-2 border border-secondary">
                            Filter by date, type, search
                        </div>


                            <livewire:admin.endless-media />


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
