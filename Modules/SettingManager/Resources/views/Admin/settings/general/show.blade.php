@extends('layouts.admin.master')
@section('title') Settings @stop
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Setting
                <small>Setting Detail</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{route('setting.general')}}">Settings</a></li>
                <li><a href="javascript:void(0)" class="active">Setting Detail</a></li>
            </ol>
        </section>
        <section class="content" data-table="settings">
            <div class="box">

                <div class="box-header"><h3 class="box-title">Office Address</h3>
                    <a href="{{route('setting.general')}}" class="btn btn-default pull-right" title="Cancel"><i
                        class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                </div>

                <div class="box-body">

                    <table class="table table-hover table-striped">
                        <tbody><tr>
                            <th scope="row">Title</th>
                            <td>{{$settings->title}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Manager</th>
                            <td>{{$settings->manager}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Constant/Slug</th>
                            <td>{{$settings->slug}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Config Value</th>
                            <td>{{$settings->config_value}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Field Type</th>
                            <td>{{$settings->field_type}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Created</th>
                            <td>{{$settings->created_at}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Modified</th>
                            <td>{{$settings->updated_at}}</td>
                        </tr>
                        </tbody></table>

                </div>
            </div>
        </section>
@stop
