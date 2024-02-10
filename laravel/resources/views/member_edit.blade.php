    <form method="post" name="user" action="{{ route('member_edit', $data['user']->id) }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        {!! csrf_field() !!}
        <input type="hidden" name="update_type" value="Profile" />
        <div class="row">
            <div class="col-12 mb-3">
                <h3 class="fw-bold">
                    <i class="fas fa-user text-primary"></i>
                    Primary Contact Information
                </h3>
            </div>
            <div class="col-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Email</span>
                    </div>
                    <input type="text" class="form-control"  placeholder="Email" name="user[email]"
                           value="{{ old('user.email', $data['user']->email ?? '')}}" size="80" required/>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" name="user_info[share_email]" type="checkbox" value="1"
                                   aria-label="Checkbox for following text input"
                                {{ checked(old('user_info.share_email', $data['user']->user_info->share_email ?? '')) }}
                            >
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                               value="Check to share email in profile" readonly>
                    </div>
                    <input name="user_info[share_email]" type="hidden" value="0" />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Phone</span>
                    </div>
                    <input type="tel" class="form-control"  placeholder="Phone" name="user_phone[phone_number]"
                           value="{{ old('user_phone.phone_number',
                           $data['user']->phone_number->phone_number ?? '') }}"
                           size="80" maxlength="20" />
                </div>
                <div class="input-group mb-4 mb-lg-4">
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" name="user_info[share_phone]" type="checkbox" value="1"
                                   aria-label="Checkbox for following text input"
                                {{ checked(old('user_info.share_phone',
                                    $data['user']->user_info->share_phone ?? '')) }}
                            >
                        </div>
                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                           value="Check to share phone number in profile" readonly>
                        <input name="user_info[share_phone]" type="hidden" value="0" />
                    </div>
                </div>
            </div>
            <div class="col-12 mt-md-3">
               <h5>
                   <i>
                       <i class="fas fa-asterisk"></i>
                       Note: This form will email the office contacts with updates
                       to your email address & phone number.
                   </i>
               </h5>
            </div>
        </div>

        <div class="col-12 pt-2">
            <h3 class="mt-3 p-lg-2 fw-bold">
                <i class="fas fa-user text-primary"></i>
                Member Info
            </h3>
            <div class="input-group mb-3">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" name="user_info[show_profile]" type="checkbox" value="1"
                           aria-label="Checkbox for following text input"
                        {{ checked(old('user_info.show_profile',
                            $data['user']->user_info->show_profile ?? '')) }}
                    >
                </div>
                <input type="text" class="form-control" aria-label="Text input with checkbox"
                       value="Check to share your profile with members" readonly>
                <input name="user_info[show_profile]" type="hidden" value="0" />
            </div>
            @if( isset($data['user']->user_info->image) )
                <div class="row mb-3">
                    <div class="col-12 mt-5 text-center">
                        <h4>
                            <i class="far fa-images"></i>
                            File name: {{ $data['user']->user_info->file_name }}

                        </h4>
                        <p class="d-sm-block d-md-none">
                            <i>(Thumbnail for mobile view)</i>
                        </p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-0 col-md-3">
                    </div>
                    <div class="col-12 col-md-6 text-center d-flex align-items-center justify-content-center">
                        <picture>
                            <source srcset="{{asset('storage/'. $data['folder'] .'/'. $data['user']->user_info->image)}}"
                                    media="(min-width: 577px)">
                            <img srcset="{{asset('storage/'. $data['folder'] ."/". $data['tn_prefix'].$data['user']->user_info->image)}}"
                                 alt="{{$data['user']->name}}"
                                 class="rounded img-fluid mx-auto">
                        </picture>
                    </div>
                    <div class="col-0 col-md-3">
                    </div>
                </div>
                <div class="col-12 text-center">
                    <input type="hidden" name="user_info[image]" value="{{$data['user']->user_info->image}}" />
                    <input type="hidden" name="user_info[file_name]" value="{{$data['user']->user_info->file_name}}" />
                    <h5>
                        {{"File Size: " . $data['filesize'] ?? ''}}
                    </h5>
                    <p class="d-sm-block d-md-none">
                        <i>(Size is for full size image)</i>
                    </p>
                </div>
                <div class="input-group mb-6">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" name="user_info[delete_image]" type="checkbox" value="1"
                               aria-label="Checkbox for following text input"
                        >
                    </div>
                    <input type="text" class="form-control" aria-label="Text input with checkbox"
                           value="Check to delete the current image" readonly>
                </div>
            @else
                <input name="user_info[delete_image]" type="hidden" value="" />
                <div class="form-group">
                    <label for="exampleInputFile">
                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                            File input
                    </label>
                    <input type="file" id="inputFile" name="image" />
                    <p class="help-block">
                        <i>Upload an image for your profile if you wish.
                            Use something you have permission to use.</i>
                    </p>
                </div>
            @endif
            <div class="input-group mt-3 pb-3">
               <div class="input-group-text">
                    <input class="form-check-input mt-0" name="user_info[show_picture]" type="checkbox" value="1"
                           aria-label="Checkbox for following text input"
                        {{ checked(old('user_info.show_picture', $data['user']->user_info->show_picture ?? '')) }}
                    >
               </div>
               <input type="text" class="form-control" aria-label="Text input with checkbox"
                  value="Check to show picture in your profile" readonly>
               <input name="user_info[show_picture]" type="hidden" value="0" />
            </div>
            <h3 class="mt-2 p-2 fw-bold">
                <i class="fas fa-user text-primary"></i>
                About Me
            </h3>
            <div class="col-12 input-group mb-3 d-flex justify-content-center">
                @if (!optional($data['user']->user_info)->about || empty(optional($data['user']->user_info)->about))
                    <p class="font-italic">
                        Add something here about you such as your experience in
                        stage and theatre, your skills. Do you have a side hustle?
                        Got creative work? Tell us about it! Share your social media
                        links if you like.
                    </p>
                @endif
                <textarea name="user_info[about]" id="about" class="form-control">
                    {{ old('user_info.about', $data['user']->user_info->about ?? '') }}
                </textarea>
            </div>
            <div class="pt-5 pl-2 m-2">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-primary btn-lg" type="submit" value="Update My Profile" />
            </div>
    </form>
</div>

    @if( $data['user']->allExecutiveRoles->count() > 0 )
        <div class="col-12 col-lg-5 border border-dark rounded p-2">
            <h4>Executive {{ Str::plural('Title', $data['user']->allExecutiveRoles->count()) }}</h4>
            <ul class="list-group">
                @foreach($data['user']->allExecutiveRoles as $exec)
                    <li class="list-group-item">{{$exec->title}}
                        {{ \Carbon\Carbon::parse($exec->pivot->end_date)->isPast() ? '':'(Currently)'}}
                        <a href="mailto:{{$exec->email}}" title="Email {{$data['user']->name}} {{$exec->title}}
                                at {{$exec->email}}">
                            <i class="fas fa-envelope"></i>
                        </a> <br />
                        {{\Carbon\Carbon::parse($exec->pivot->start_date)->format('M j Y')}} -
                        {{\Carbon\Carbon::parse($exec->pivot->end_date)->format('M j Y')}}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if($data['user']->committee_memberships->count() > 0)
        <div class="col-12 col-lg-5 border border-dark rounded p-2">
            <h4>Membership in committees</h4>
            <ul class="list-group">
                @foreach($data['user']->committee_memberships as $m)
                    @if($m->pivot->role != 'Past-Member')
                        <li class="list-group-item">
                            <a href="{{ route('committee', $m->slug) }}" title="{{$m->name}}">
                                {{$m->name}} - {{$m->pivot->role}}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif
