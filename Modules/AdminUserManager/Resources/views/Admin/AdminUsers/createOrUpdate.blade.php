@extends('layouts.admin.master')
@section('title', !empty($adminUser) ? 'Update Profile' : 'Add Profile')
@section('content')
@include('layouts.admin.flash.alert')
    <!-- Content Header (adminUser header) -->
    <section class="content-header">

        <h1>
            Manage Admin Users
            <small>Here you can update admin profile</small>
        </h1>
        {{ Breadcrumbs::render('common',['append' => [['label'=> 'Update Profile']]]) }}
    </section>
    <section class="content" data-table="adminUsers">
            <div class="row adminUsers">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ !empty($adminUser) ? 'Edit Profile' : 'Add Admin User' }} </h3>

                        </div><!-- /.box-header -->

                @if(isset($adminUser))
                    {{ Form::model($adminUser, ['url' => route('admin.update-profile') , 'method' => 'patch']) }}
                @else
                    {{ Form::open(['url' => route('admin.update-profile', app('request')->query())]) }}
                @endif
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="name">Full Name</label>
                                    <div class="col-md-6">
                                        {{ Form::text('name', old('name'), ['class' => 'form-control','placeholder' => 'First Name']) }}
                                        @if($errors->has('name'))
                                        <span class="help-block">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                              </div>

                              <div class="form-group required {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <div class="row">
                                        <label class="col-md-3 control-label" for="last_name">Email</label>
                                        <div class="col-md-6">
                                            {{ Form::text('email', old('email'), ['type' => 'email','class' => 'form-control','placeholder' => 'Email']) }}
                                            @if($errors->has('email'))
                                            <span class="help-block">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                              </div>

                              <div class="form-group required {{ $errors->has('mobile') ? 'has-error' : '' }}">
                                    <div class="row">
                                        <label class="col-md-3 control-label" for="last_name">Mobile</label>
                                        <div class="col-md-6">
                                            {{ Form::text('mobile', old('mobile'), ['class' => 'form-control','placeholder' => 'Mobile']) }}
                                            @if($errors->has('mobile'))
                                            <span class="help-block">{{ $errors->first('mobile') }}</span>
                                            @endif
                                        </div>
                                    </div>
                              </div>


                        </div>
                    </div> <!-- /.row -->
                </div><!-- /.box-body -->
                <div class="box-footer">
                        <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Update </button>
                    </div>
                    {{ Form::close() }}

                    </div>
                </div>
            </div>
        </section>
@stop
