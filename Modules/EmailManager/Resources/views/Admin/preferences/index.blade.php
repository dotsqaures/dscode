@extends('layouts.admin.master')
@section('title','Email preferences')
@section('content')
@include('layouts.admin.flash.alert')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Email Preference
            <small>Here you can manage the email preferences(layouts)</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="javascript:void(0)" class="active">Email preferences</a></li>
        </ol>
    </section>
    <section class="content" data-table="emailHooks">
        <div class="row emailHooks">
            <div class="col-md-7">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"><span class="caption-subject font-green bold uppercase">{{ __('List Email Preferences') }}</span></h3>
                        <div class="box-tools">
                           <!-- <a href="{{route('admin.email-preferences.create')}}" class="btn btn-success btn-flat"><i class="fa fa-plus"></i>  New Email Preference</a>-->
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                     @if (!$emailPreferences->isEmpty())
                            <ul class="timeline">
                               @foreach ($emailPreferences as $emailPreference)
                                    <li class="time-label">
                                        <span class="bg-navy">
                                            {{ $emailPreference->created_at->toFormattedDateString() }}
                                        </span>
                                    </li>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <li>
                                        <i class="fa fa-anchor bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {{ $emailPreference->created_at->format('H:i A') }}</span>

                                            <h3 class="timeline-header">
                                                {{ $emailPreference->title }}
                                            </h3>
                                            <div class="timeline-footer form-inline">
                                            <a href="{{ route('admin.email-preferences.show', ['id' => $emailPreference->id]) }}" class="btn btn-default btn-xs btn-flat"><i class="fa fa-eye" data-toggle="tooltip" data-placement="left" data-title="View" data-original-title="" title=""></i></a>
                                            <a href="{{ route('admin.email-preferences.edit', ['id' => $emailPreference->id]) }}" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="right" data-title="Edit" data-original-title="Edit" title=""></i></a>
                                        </div>
                                        </div>
                                    </li>
                                @endforeach
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                            @else
                            <div style="align:center;">  <strong>Record Not Available</strong> </div>
                            @endif
                    </div>

                </div>
            </div>
            <div class="col-md-5">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-exclamation"></i> Important Rules
                            </h3>

                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <p>
                                For each email style or email preference that would be added to the system, make sure it has these hooks:
                            </p>
                            <ul>
                                <li>
                                    <small class="label bg-yellow">
                                        ##SYSTEM_LOGO##
                                    </small> - Will be replaced by logo from the admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        ##SYSTEM_APPLICATION_NAME##
                                    </small> - Will be replaced by application name from admin settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        ##EMAIL_CONTENT##
                                    </small> - Will be replaced by email message from email hook settings.
                                </li>
                                <li>
                                    <small class="label bg-yellow">
                                        ##EMAIL_FOOTER##
                                    </small> - Will be replaced by email footer from email hook settings.
                                </li>
                            </ul>
                        </div><!-- ./box-body -->
                    </div>
                </div>
        </div>
    </section>
@stop
