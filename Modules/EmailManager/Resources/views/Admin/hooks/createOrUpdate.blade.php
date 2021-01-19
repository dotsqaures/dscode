@extends('layouts.admin.master')
@section('title', !empty($emailHook) ? 'Edit Email Hook' : 'Add Email Hook')
@section('content')
@include('layouts.admin.flash.alert')
<section class="content-header">
    <h1>
        Manage Email Hooks
        <small>Here you can {{ !empty($emailHook) ? 'edit' : 'add' }} email hook(slug)</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route("admin.dashboard") }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.hooks')}}">{{ __("Hooks") }}</a></li>
        <li><a href="javascript:void(0)" class="active">{{ !empty($emailHook) ? 'Edit Email Hook' : 'Add Email Hook' }}</a></li>
    </ol>
</section>
<section class="content" data-table="emailHooks">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-info emailHooks">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ !empty($emailHook) ? 'Edit Email Hook' : 'Add Email Hook' }} </h3>
                    <a href="{{ route('admin.hooks') }}" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                </div><!-- /.box-header -->

                @if(isset($emailHook))
                    {{ Form::model($emailHook, ['route' => ['admin.edit-hooks', $emailHook->id], 'method' => 'patch']) }}
                @else
                    {{ Form::open(['route' => 'admin.save-hooks']) }}
                @endif

                <div class="box-body">
                    <div class="row">
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
                        <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>  
                        <a href="{{ route('admin.hooks') }}" class="btn btn-warning btn-flat" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>                
                    </div>
                    {{ Form::close() }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-anchor"></i> Last updated email hooks</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- form start -->
                    <!-- form start -->
                    @if (!$emailHookLists->isEmpty())
                        <ul class="timeline">
                            <!-- timeline time label -->
                            @foreach ($emailHookLists as $hook)
                                <li class="time-label">
                                    <span class="bg-navy">
                                            {{ $hook->created_at->toFormattedDateString() }}
                                    </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class="fa fa-anchor bg-blue"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> {{ $hook->created_at->format('H:i A') }}</span>

                                        <h3 class="timeline-header">{{ $hook->title }}</h3>

                                        <div class="timeline-body">
                                                {{ $hook->description }}
                                        </div>
                                        <div class="timeline-footer">
                                                <a href="{{ route('admin.view-hooks', ['id' => $hook->id]) }}" class="btn btn-default btn-xs btn-flat"><i class="fa fa-eye" data-toggle="tooltip" data-placement="left" data-title="View" data-original-title="" title=""></i></a>
                                                <a href="{{ route('admin.edit-hooks', ['id' => $hook->id]) }}" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="right" data-title="Edit" data-original-title="Edit" title=""></i></a> 

                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                           @endforeach

                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                        </ul>
                    @endif
                </div>

            </div>
            <!-- /.box -->
        </div>
    </div>
</section>

@endsection