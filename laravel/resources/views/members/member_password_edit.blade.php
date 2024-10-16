    <form method="post" name="password_edit" action="{{ route('member_password_update', $data['user']->id) }}"
          enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        <div class="row pt-2">
            <div class="col-12 mb-3">
                <h3 class="">
                    <i class="fas fa-unlock-alt"></i>
                    Update Your Password
                </h3>
                <h5>
                    Your password must be a minimum of 6 characters.
                    Do not use an easily guessable password.
                </h5>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Password</span>
                </div>
                <input type="password" class="form-control" name="password"
                       value="{{ old('password', $password ?? '')}}" size="80" required/>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Repeat Password</span>
                </div>
                <input type="password" class="form-control" name="password_confirmation"
                       value="{{ old('password_confirmation', $password_confirmation ?? '')}}" size="80" required/>
            </div>

            <div class="col-12 mt-2 mb-2">
                <i class="fas fa-edit fa-2x"></i>
                <input class="btn btn-outline-primary" type="submit" value="Update My Password" />
            </div>
        </div>
    </form>
