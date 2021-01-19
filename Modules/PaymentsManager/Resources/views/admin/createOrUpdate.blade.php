@extends('layouts.admin.master')
@section('title', !empty($headlines) ? 'Edit Tagline' : 'Add Tagline')
@section('content')
@include('layouts.admin.flash.alert')

    <!-- Content Header (category header) -->
    <section class="content-header">
        <h1>
            Manage Product Taglines
            <small>Here you can {{ !empty($headlines) ? 'edit' : 'add' }} Taglines</small>
        </h1>


        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="https://webappdeveloment.24livehost.com/public/admin/dashboard">
                <i class="fa fa-dashboard"></i>
                Home</a></li>

            <li class="breadcrumb-item"><a href="https://webappdeveloment.24livehost.com/public/admin/HeadlineOnes">
                Tagline</a></li>

                @if(!empty($headlines))
            <li class="breadcrumb-item active">
                Edit Tagline
                @else
                <li class="breadcrumb-item active">
                    Add Tagline

                @endif
</li>

</ol>
    </section>
    <section class="content" data-table="HeadlineOnes">
            <div class="row categories">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ !empty($headlines) ? 'Edit Tagline' : 'Add Tagline' }} </h3>
                            <a href="{{ route('admin.HeadlineOnes.index') }}" class="btn btn-default pull-right" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                        </div><!-- /.box-header -->

                @if(isset($headlines))
                    {{ Form::model($headlines, ['route' => ['admin.HeadlineOnes.update', $headlines->id], 'method' => 'patch','files'=>'true']) }}
                @else
                    {{ Form::open(['route' => 'admin.HeadlineOnes.store','files'=>'true']) }}
                @endif
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">



                              <div class="form-group required {{ $errors->has('tag_title') ? 'has-error' : '' }}">
                                <label for="title">Tagline Title</label>
                                {{ Form::text('tag_title', old('tag_title'), ['class' => 'form-control','placeholder' => 'Title']) }}
                                @if($errors->has('tag_title'))
                                    <span class="help-block">{{ $errors->first('tag_title') }}</span>
                                    @endif
                               </div>


                              <div class="form-group required {{ $errors->has('tag_description') ? 'has-error' : '' }}">
                                    <label for="description">Tagline Description</label>
                                    {{ Form::textarea('tag_description', old('tag_description'), ['class' => 'form-control','placeholder' => 'Tagline Description', 'rows' => 4]) }}
                                    @if($errors->has('tag_description'))
                                    <span class="help-block">{{ $errors->first('tag_description') }}</span>
                                    @endif
                                </div>


                              <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label class="control-label" for="last_name">Status</label>
                                            {{ Form::select('status', [1 => 'Active', 0 => 'Inactive'], old("status"), ['class' => 'form-control']) }}
                               </div>




                        </div>




                    </div> <!-- /.row -->


                </div><!-- /.box-body -->
                <div class="box-footer">
                        <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>
                        <a href="{{ route('admin.HeadlineOnes.index') }}" class="btn btn-warning btn-flat" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                    </div>
                    {{ Form::close() }}

                    </div>
                </div>
            </div>
        </section>

@stop



