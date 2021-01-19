@extends('layouts.admin.master')
@section('title', !empty($category) ? 'Edit Category' : 'Add Category')
@section('content')
@include('layouts.admin.flash.alert')
    <!-- Content Header (category header) -->
    <section class="content-header">
        <h1>
            Manage Catgeory
            <small>Here you can {{ !empty($category) ? 'edit' : 'add' }} Catgeory</small>
        </h1>
        {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.categories.index'],['label' => !empty($category) ? 'Edit Category' : 'Add Category' ]]]) }}
    </section>
    <section class="content" data-table="categories">
            <div class="row categories">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ !empty($category) ? 'Edit Catgeory' : 'Add Catgeory' }} </h3>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-default pull-right" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                        </div><!-- /.box-header -->

                @if(isset($category))
                    {{ Form::model($category, ['route' => ['admin.categories.update', $category->id], 'method' => 'patch','files'=>'true']) }}
                @else
                    {{ Form::open(['route' => 'admin.categories.store','files'=>'true']) }}
                @endif
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                                <label class="control-label" for="last_name">Parent Category</label>
                                        {{ Form::select('parent_id', $Parentcategories, old("parent_id"), ['class' => 'form-control']) }}
                           </div>

                              <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title">Title</label>
                                {{ Form::text('title', old('title'), ['class' => 'form-control','placeholder' => 'Title']) }}
                                @if($errors->has('title'))
                                <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                              </div>

                              <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                <label for="title">Slug</label>
                                {{ Form::text('slug', old('slug'), ['class' => 'form-control','placeholder' => 'Slug']) }}
                                @if($errors->has('slug'))
                                <span class="help-block">{{ $errors->first('slug') }}</span>
                                @endif
                              </div>

                              <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label class="control-label" for="last_name">Status</label>
                                            {{ Form::select('status', [1 => 'Active', 0 => 'Inactive'], old("status"), ['class' => 'form-control']) }}
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
                                {{ Form::textarea('meta_description', old('meta_description'), ['class' => 'form-control','placeholder' => 'Meta Description', 'rows' => 4]) }}
                                @if($errors->has('meta_description'))
                                <span class="help-block">{{ $errors->first('meta_description') }}</span>
                                @endif
                            </div>







                        </div>


                    </div> <!-- /.row -->


                </div><!-- /.box-body -->
                <div class="box-footer">
                        <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-warning btn-flat" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                    </div>
                    {{ Form::close() }}

                    </div>
                </div>
            </div>
        </section>
@stop
