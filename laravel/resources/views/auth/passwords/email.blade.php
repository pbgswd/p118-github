@extends('layouts.jumbo', ['data' => ['title' => "Reset Your Password"]])
@section('content')
<div class="container">
    <div class="row mt-5 mb-5 pb-5 justify-content-center">
        <div class="col-md-8 pt-5">
            <div class="card">
                <div class="card-header font-weight-bold bg-dark text-white">{{ __('Reset Password') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group row font-weight-bold">
                            <label for="email" class="col-md-4 col-form-label text-md-right">
                                {{ __('E-Mail Address') }}
                            </label>
                            <div class="col-md-6 pb-2 mb-3">
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row pb-5">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="h4">
                        <i class="fas fa-exclamation-triangle fa-2x" style="color: red;"></i>
                        Are you a member of IATSE 118 and haven't logged in before?
                        Just enter your email to get a password reset emailed to you
                        so you may log in.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
