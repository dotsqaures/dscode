@extends('layouts.admin.master')
@section('title','View Email Hook')
@section('content')
@include('layouts.admin.flash.alert')
<section class="content-header">
        <h1>
                Manage Email Templates 
                <small>Here you can manage the email templates</small>
            </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route("admin.dashboard") }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.email-templates.index')}}">Email Templates</a></li>
        <li><a href="javascript:void(0)" class="active">View Email Templates Detail</a></li>
    </ol>
</section>

<section class="content" data-table="emailTemplates">
    <div class="box">
        <div class="box-header"><h3 class="box-title">{{ $emailTemplate->title }}</h3>
            <a href="{{route('admin.email-templates.index')}}" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
        </div>
        <div class="box-body">
            <table class="table table-hover table-striped">
                <tr>
                    <th scope="row">{{ __('Hook/Slug') }}</th>
                    <td>{{ $emailTemplate->email_hook->title }}</td>
                </tr>
                <tr>
                    <th scope="row">{{ __('Subject') }}</th>
                    <td>{{ $message['subject'] }}</td>
                </tr>
                <tr>
                        <th scope="row">{{ __('Status') }}</th>
                        <td>{{ $emailTemplate->status == 1 ? "Active" : "Inactive" }}</td>
                    </tr>
               <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td>{{ $emailTemplate->created_at->toFormattedDateString() }}</td>
                </tr>
                <tr>
                    <th scope="row">{{ __('Modified') }}</th>
                    <td>{{ $emailTemplate->updated_at->toFormattedDateString() }}</td>
                </tr>
               
            </table>
            <div class="row">
                <div class="col-md-12">
                    <h4>{{ __('Email Template Layout') }}</h4>
                    {!! $message['message'] !!}
                </div>
            </div>
        </div>
        <div class="box-footer">
                <a href="{{route('admin.email-templates.index')}}" class="btn btn-default pull-left" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
        </div>
    </div>
</section>
@endsection