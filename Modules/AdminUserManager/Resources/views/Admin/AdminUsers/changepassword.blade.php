@extends('layouts.admin.master')
@section('title', 'Change Current Password')
@section('content')
@include('layouts.admin.flash.alert')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Change Password
        </h1>
        {{ Breadcrumbs::render('common',['append' => [['label'=> "Change Password"]]]) }}
    </section>
    <section class="content" data-table="pages">
            <div class="row pages">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ __("Change Password") }}</h3>
                        </div><!-- /.box-header -->
                    {{ Form::open(['route' => 'admin.updatepassword']) }}
                <div class="box-body">
                    <div class="row">
                            <div class="col-md-8 com-md-offset-2">
                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                    <div class="row">
                                <label for="new-password" class="col-md-4 control-label">Current Password</label>
                                <div class="col-md-6">
                                    <input id="current-password" value="{{ old("current-password") }}" type="password" class="form-control" name="current-password" placeholder="Current Password" required>

                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                    </div>
                            </div>

                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                    <div class="row">
                                <label for="new-password" class="col-md-4 control-label">New Password</label>
                                <div class="col-md-6">
                                    <input id="new-password" type="password" value="{{ old("new-password") }}" class="form-control" placeholder="New Password" name="new-password" required>
                                    @if ($errors->has('new-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                    </div>
                            </div>

                            <div class="form-group">
                                    <div class="row">
                                <label for="new-password-confirm" class="col-md-4 control-label">Confirm New Password</label>
                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password" value="{{ old("new-password_confirmation") }}" class="form-control" name="new-password_confirmation" placeholder="Confirm New Password" required>
                                </div>
                                    </div>
                            </div>
                    </div>

                    </div> <!-- /.row -->
                 </div><!-- /.box-body -->
                <div class="box-footer">
                        <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Change Password</button>
                    </div>
                    {{ Form::close() }}
                    </div>
                </div>
            </div>
        </section>
@stop
