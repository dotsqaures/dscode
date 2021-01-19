@extends('layouts.admin.login')
@section('title','Reset Password')
@section('content')
@if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <p class="login-box-msg" style="padding-bottom: 5px;">{{ __('Forgot Password ?') }}</p>
    <p  style="padding-left: 15px;"><small>Enter your e-mail address below to reset your password.</small> </p>
    <form method="POST" action="{{ route('admin.password.email') }}">
            @csrf
    <div class="form-group has-feedback">
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter your e-mail address" name="email" value="{{ old('email') }}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>

    <div class="row">
        <div class="col-xs-4 pull-left">
                <a href="{{ route('admin.login') }}" class="btn btn-default btn-block btn-flat">Back</a>
        </div><!-- /.col -->
        <div class="col-xs-8 pull-right">
                <button type="submit" class="btn btn-primary btn-block btn-flat">
                        {{ __('Send Password Reset Link') }}
                    </button>
        </div><!-- /.col -->
    </div>
</form>
    <br>
@endsection
