@extends('layouts.admin.master')
@section('title','View Email Hook')
@section('content')
@include('layouts.admin.flash.alert')
<section class="content-header">
    <h1>
        Manage Email Hooks
        <small>Here you can view email hooks(slug) details</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route("admin.dashboard") }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('admin.email-preferences.index')}}">Email Preferences</a></li>
        <li><a href="javascript:void(0)" class="active">View Email Hook Detail</a></li>
    </ol>
</section>

<section class="content" data-table="emailPreferences">
    <div class="box">
        <div class="box-header"><h3 class="box-title">{{ $emailPreference->title }}</h3>
            <a href="{{route('admin.email-preferences.index')}}" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
        </div>
        <div class="box-body">
            <table class="table table-hover table-striped">
                <tr>
                    <th scope="row">{{ __('Title') }}</th>
                    <td>{{ $emailPreference->title }}</td>
                </tr>
               <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td>{{ $emailPreference->created_at->toFormattedDateString() }}</td>
                </tr>
                <tr>
                    <th scope="row">{{ __('Modified') }}</th>
                    <td>{{ $emailPreference->updated_at->toFormattedDateString() }}</td>
                </tr>
               
            </table>
            <div class="row">
                <div class="col-md-12">
                    <h4>{{ __('Layout Html') }}</h4>
                    {!! $emailPreference->layout_html !!}
                </div>
            </div>
        </div>
        <div class="box-footer">
                <a href="{{route('admin.email-preferences.index')}}" class="btn btn-default pull-left" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
        </div>
    </div>
</section>
@endsection