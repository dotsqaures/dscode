@extends('layouts.admin.master')
@section('title','Email Hooks')
@section('content')
@include('layouts.admin.flash.alert')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Email Hooks
            <small>Here you can manage email hooks(slug)</small>
        </h1>
        {{ Breadcrumbs::render('common',['append' => [['label'=>'Cms Pages','route'=> \Request::route()->getName()]]]) }}
    </section>
    <section class="content" data-table="emailHooks">

        @php
        echo "<pre>";
                $action = app('request')->route()->getAction();
         print_r($action);
         $controller = class_basename($action['controller']);

         list($controller, $action) = explode('@', $controller);
         print_r($controller);
         echo "</pre>";
        @endphp

        <div class="row emailHooks">
            <div class="col-md-7">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><span class="caption-subject font-green bold uppercase">List {{ __('Email Hooks') }}</span></h3>
                        <div class="box-tools">
                            <a href="{{route('admin.add-hooks')}}" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> New Email Hook</a>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">

                    </div>

                </div>
            </div>
            <div class="col-md-5">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-anchor"></i> Quick Start</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    {{ Form::open(['route' => 'admin.save-hooks']) }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger print-error-msg" style="display:none">
                                        <ul></ul>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
                                        <label for="title">Title</label>
                                        {{ Form::text('title', old('title'), ['class' => 'form-control','placeholder' => 'Title']) }}
                                        @if($errors->has('title'))
                                        <span class="help-block">{{ $errors->first('title') }}</span>
                                        @endif

                                        </div>
                                    <div class="form-group">
                                        <label for="slug">Hook</label>
                                        {{ Form::text('slug', old('slug'), ['class' => 'form-control','placeholder' => 'Hook/Slug' ,'readonly' => isset($emailHook) ? true : false]) }}
                                        <p class="help-block">No space, separate each word with underscore. (if you want auto generated then please leave blank)</p>
                                    </div>
                                    <div class="form-group required {{ $errors->has('description') ? 'has-error' : '' }}">
                                        <label for="description">Description</label>
                                        {{ Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => 'Description', 'rows' => 8]) }}
                                        {{-- <textarea name="description" class="form-control" placeholder="Description" required="required" id="description" rows="5">{{ old("description") ? old("description") : (!empty($emailHook) ? $emailHook->description : '') }}</textarea> --}}
                                        @if($errors->has('description'))
                                        <span class="help-block">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        {{ Form::select('status', [1 => 'Active', 0 => 'Inactive'], old("status"), ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div> <!-- /.row -->
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button class="btn btn-primary l-button" data-size="xs" title="Submit" type="submit"><span class="ladda-label"><i class="fa fa-fw fa-save"></i> Submit</span></button>
                        </div>
                        {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@stop
