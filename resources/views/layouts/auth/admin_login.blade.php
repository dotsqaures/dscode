@extends('frontend.layouts.app')

@section('content')
<div class="row" style="margin-top: 50px;">

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading admin-login-panel-heading">
                @include('frontend.includes.sitelogo')
            </div>

            <div class="panel-body">
                <div class="admin-logo-login-section">{{ trans('labels.frontend.auth.login_box_title') }}</div>
                {{ Form::open(['route' => 'admin.login', 'class' => 'form-horizontal form-prevent-multiple-submissions', 'id' => 'admin-login']) }}

                <div class="form-group">
                    {{ Form::label('email', trans('validation.attributes.frontend.register-user.email'), ['class' => 'col-md-4 control-label required']) }}
                    <div class="col-md-6">
                        @if (Cookie::get('email') !== null)
                            {{ Form::input('email', 'email' , Cookie::get('email'), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email')]) }}
                        @else
                            {{ Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email'), 'autocomplete'=>'off']) }}
                        @endif
                    </div><!--col-md-6-->
                </div><!--form-group-->

                <div class="form-group">
                    {{ Form::label('password', trans('validation.attributes.frontend.register-user.password'), ['class' => 'col-md-4 control-label required']) }}
                    <div class="col-md-6">
                        @if (Cookie::get('password') !== null)
                            {{ Form::input('password', 'password',  Cookie::get('password'), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password')]) }}
                        @else
                            {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password'), 'autocomplete'=>'off']) }}
                        @endif
                    </div><!--col-md-6-->
                </div><!--form-group-->

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        {{ Form::submit(trans('labels.frontend.auth.login_button'), ['class' => 'btn btn-primary button-prevent-mutiple-submissions', 'style' => 'margin-right:15px']) }}
                        {{ link_to_route('admin.password.reset', trans('labels.frontend.passwords.forgot_password')) }}
                    </div><!--col-md-6-->
                </div><!--form-group-->

                {{ Form::close() }}

            </div><!-- panel body -->

        </div><!-- panel -->

    </div><!-- col-md-8 -->

</div><!-- row -->

@endsection

<style>
.navbar-default{
    display:none !important;
}
</style>


