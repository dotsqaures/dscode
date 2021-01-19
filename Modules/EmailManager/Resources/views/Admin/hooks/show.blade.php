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
        <li><a href="{{route('admin.hooks')}}">Hooks</a></li>
        <li><a href="javascript:void(0)" class="active">View Email Hook Detail</a></li>
    </ol>
</section>

<section class="content" data-table="emailHooks">
    <div class="box">
        <div class="box-header"><h3 class="box-title">{{ $email_hook->title }}</h3>
            <a href="{{route('admin.hooks')}}" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
        </div>
        <div class="box-body">
            <table class="table table-hover table-striped">
                <tr>
                    <th scope="row">{{ __('Title') }}</th>
                    <td>{{ $email_hook->title }}</td>
                </tr>
                <tr>
                    <th scope="row">{{ __('Hook/Slug') }}</th>
                    <td>{{ $email_hook->slug }}</td>
                </tr>

                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td>{{ $email_hook->created_at->toFormattedDateString() }}</td>
                </tr>
                <tr>
                    <th scope="row">{{ __('Modified') }}</th>
                    <td>{{ $email_hook->updated_at->toFormattedDateString() }}</td>
                </tr>
                <tr>
                    <th scope="row">{{ __('Status') }}</th>
                    <td>{{ $email_hook->status ? __('Active') : __('Inactive')  }}</td>
                </tr>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <h4>{{ __('Description') }}</h4>
                    {{ $email_hook->description }}
                </div>
            </div>
        </div>
        <div class="box-footer">
                <a href="{{route('admin.hooks')}}" class="btn btn-default pull-left" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
        </div>
    </div>
</section>

@endsection