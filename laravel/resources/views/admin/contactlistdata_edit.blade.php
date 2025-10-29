@extends('layouts.dashboard',  ['title_icon' => ' <i class="fas fa-edit"></i>', 'title' => $data["action"]. ' Employer Contacts ' .
    ($data["action"] == 'Edit' ? $data['cldata']->title : '') ])
@section('content')
    @include('admin.admin_partials.admin_tinymce')
<div class="container">
    <div class="row my-4">
        <div class="col-12 col-md-3">
            <h4>
                <a href="{{ route('contactlist_list') }}">
                    <i class="far fa-arrow-alt-circle-left"></i>
                    Go back
                </a>
            </h4>
        </div>
        @if ($data['action'] == 'Edit')
            <div class="col-12 col-md-3 text-md-right">
                <h4>
                    <a href="{{route('post_show', $data['cldata']->id)}}"
                       title="View {{$data['cldata']->title}}">
                        <i class="fas fa-eye"></i> View on website
                    </a>
                </h4>
            </div>
        @endif
    </div>
    <form method="post" name="post" action="{{url()->current()}}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <div class="row my-2">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="Name" name="cld[name]"
                               value="{{ $data['cld']['name'] ?? ''}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Address 1</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="Address 1" name="cld[addr1]"
                               value="{{ $data['cld']['addr1'] ?? ''}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Address 2</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="Address 2" name="cld[addr2]"
                               value="{{ $data['cld']['addr2'] ?? ''}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">City</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="City" name="cld[city]"
                               value="{{ $data['cld']['city'] ?? ''}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Province or State</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="Prov/state" name="cld[province]"
                               value="{{ $data['cld']['province'] ?? ''}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Country</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="Country eg: Canada, USA" name="cld[country]"
                               value="{{ $data['cld']['country'] ?? ''}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Postal Code</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="Postal Code" name="cld[postal_code]"
                               value="{{ $data['cld']['postal_code'] ?? ''}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Website</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="https://www..." name="cld[website]"
                               value="{{ $data['cld']['website'] ?? ''}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="Email" name="cld[email]"
                               value="{{ $data['cld']['email'] ?? ''}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Contact Person</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="Contact Person" name="cld[contact]"
                               value="{{ $data['cld']['contact'] ?? ''}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Phone</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="Phone" name="cld[phone]"
                               value="{{ $data['cld']['phone'] ?? ''}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="form-group">
                <div class="col-sm-12 col-md-8">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Postal Code</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                               placeholder="Postal Code" name="cld[postal_code]"
                               value="{{ $data['cld']['postal_code'] ?? ''}}" size="40" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
                <div class="form-group">
                    <div class="col-12 mt-3">
                        <h4>Notes</h4>
                    </div>
                    <div class="col-12">
                        <div class="col-12 mb-4">
                            <div class=" col editor-container editor-container_classic-editor" id="editor-container">
                                <div class="editor-container__editor">
                                <textarea name="contactlist[content]" id="textarea" placeholder="Content" class="form-control text-black">
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
                            var textarea = @json($data['cldata']->notes ?? '');
                            var textarea1 = @json($data['textarea1'] ?? '');
                        </script>
                        <script type="module" src="{{mix('js/admin/ckeditor5/ck_main_admin.js')}}"></script>
                    </div>
                </div>
            </div>
        <div class="row mt-3 mb-2 pb-2 pt-2">
            <div class="col-12 col-md-4 text-md-right">
                <h4>Access Level for content</h4>
            </div>
            <div class="col-12 col-md-5 text-left">
                <div class="form-group">
                    {{ select_options($data['access_levels'], old('contactlist.access_level',
                        $data['cldata']->access_level), ['name' => 'contactlist[access_level]',
                        'class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 col-md-4 text-md-right">
                <h4>Status</h4>
            </div>
            <div class="col-12 col-md-6">
                <div class="p-2">
                    <label>
                         <input name="contactlist[live]" type="hidden" value="0" />
                         <input name="contactlist[live]" type="checkbox" value="1"
                             {{ checked( old('post.live', $data['cldata']->live)) }} /> Check now to make Live
                    </label>
                    <p>ie.: Draft or Published.</p>
                </div>
            </div>
        </div>
        <div class="row m-0 mt-5 mb-5 p-0 pb-0">
            <div class="col text-left">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="{{ $data['action'] }}" />
            </div>
    </form>
            @if ($data['action'] == 'Edit')
                 <div class="col text-right">

                 </div>
            @endif
    </div>
@endsection
