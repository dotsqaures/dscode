@extends('layouts.admin.master')
@section('title', !empty($page) ? 'Edit CMS Page' : 'Add CMS Page')
@section('content')
@include('layouts.admin.flash.alert')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage CMS Pages
            <small>Here you can add cms pages</small>
        </h1>
        {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.pages.index'],['label' => !empty($page) ? 'Edit CMS Page' : 'Add CMS Page' ]]]) }}
    </section>
    <section class="content" data-table="pages">
            <div class="row pages">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ !empty($page) ? 'Edit CMS Page' : 'Add CMS Page' }} </h3>
                            <a href="{{ route('admin.pages.index') }}" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                        </div><!-- /.box-header -->

                @if(isset($page))
                    {{ Form::model($page, ['route' => ['admin.pages.update', $page->id], 'method' => 'patch']) }}
                @else
                    {{ Form::open(['route' => 'admin.pages.store']) }}
                @endif
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title">Title</label>
                                {{ Form::text('title', old('title'), ['class' => 'form-control','placeholder' => 'Title']) }}
                                @if($errors->has('title'))
                                <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                              </div>

                              <div class="form-group {{ $errors->has('sub_title') ? 'has-error' : '' }}">
                                <label for="title">Sub Title</label>
                                {{ Form::text('sub_title', old('sub_title'), ['class' => 'form-control','placeholder' => 'Sub Title']) }}
                                @if($errors->has('sub_title'))
                                <span class="help-block">{{ $errors->first('sub_title') }}</span>
                                @endif
                              </div>

                              <div class="form-group required {{ $errors->has('slug') ? 'has-error' : '' }}">
                                <label for="title">Slug</label>
                                {{ Form::text('slug', old('slug'), ['class' => 'form-control','placeholder' => 'Slug']) }}
                                @if($errors->has('slug'))
                                <span class="help-block">{{ $errors->first('slug') }}</span>
                                @endif
                              </div>


                              <div class="form-group">
                                <label for="description">Short Description</label>
                                {{ Form::textarea('short_description', old('short_description'), ['class' => 'form-control','placeholder' => 'Short Description', 'rows' => 4]) }}
                            </div>




                        </div>

                        <div class="col-md-6">
                            <div class="form-group required {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                                <label for="title">Meta Title</label>
                                {{ Form::text('meta_title', old('meta_title'), ['class' => 'form-control','placeholder' => 'Meta Title']) }}
                                @if($errors->has('meta_title'))
                                <span class="help-block">{{ $errors->first('meta_title') }}</span>
                                @endif
                              </div>

                              <div class="form-group required {{ $errors->has('meta_keyword') ? 'has-error' : '' }}">
                                <label for="title">Meta Keyword</label>
                                {{ Form::text('meta_keyword', old('meta_keyword'), ['class' => 'form-control','placeholder' => 'Meta Keyword']) }}
                                @if($errors->has('meta_keyword'))
                                <span class="help-block">{{ $errors->first('meta_keyword') }}</span>
                                @endif
                              </div>

                              <div class="form-group required {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                                <label for="description">Meta Description</label>
                                {{ Form::textarea('meta_description', old('meta_description'), ['class' => 'form-control','placeholder' => 'Meta Description', 'rows' => 8]) }}
                                @if($errors->has('meta_description'))
                                <span class="help-block">{{ $errors->first('meta_description') }}</span>
                                @endif
                            </div>

                        </div>


                    </div> <!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group required {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="description">Description</label>
                                {{ Form::textarea('description', old('description'), ['class' => 'form-control ckeditor','placeholder' => 'Description', 'rows' => 8]) }}
                                @if($errors->has('description'))
                                <span class="help-block">{{ $errors->first('description') }}</span>
                                @endif
                            </div>


                        </div>
                    </div>



                </div><!-- /.box-body -->
                <div class="box-footer">
                        <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-warning btn-flat" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                    </div>
                    {{ Form::close() }}

                    </div>
                </div>
            </div>
        </section>
@stop
