@extends('layouts.admin.master')
@section('title','Users list')
@section('content')
@include('layouts.admin.flash.alert')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage App Users
            <small>Here you can manage app user </small>
        </h1>
            {{ Breadcrumbs::render('common',['append' => [['label' => 'User Manager']]]) }}

    </section>
    @php
    $qparams = app('request')->query();
    if(!app('request')->query('role')){
        $qparams['role'] = 1;
    }
    @endphp
    <section class="content" data-table="users">
            <div class="row users">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><span class="caption-subject font-green bold uppercase">{{ __('List users') }}</span></h3>
                            <div class="box-tools">
                                <!--<a href="{{ route('admin.users.create') }}" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> Add New User</a>-->
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                                <div class="">
                                        <ul class="nav nav-tabs">

                                        </ul>
                                        <div class="tab-content" style="margin-top:10px;">
                                            {{ Form::open(['url' => route('admin.users.index', $qparams),'method' => 'get']) }}
                                            <div class="col-md-12">

                                            <div class="row">
                                                <div class="col-md-2 form-group">
                                                    {{ Form::select('status', ['' => 'All',1 => 'Active', 0 => 'Inactive'], app('request')->query('status'), ['class' => 'form-control']) }}
                                                </div>

                                                <div class="col-md-5 form-group">
                                                    {{ Form::text('keyword', app('request')->query('keyword'), ['class' => 'form-control','placeholder' => 'Keyword e.g: name, email']) }}
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <button class="btn btn-success" title="Search" type="submit"><i class="fa fa-filter"></i> Filter</button>
                                                    <a href="{{ route('admin.users.index') }}" class="btn btn-warning" title="Reset"><i class="fa fa-fw fa-refresh"></i> Reset</a>
                                                </div>
                                            </div>
                                        </div>
                                            {{ Form::close() }}
                                                <div class="tab-pane active">
                                                    <table class="table table-hover table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th scope="col">
                                                                        @php
                                                                        $sorting = $qparams;
                                                                        $sorting['sort'] = "profle_photo";
                                                                        $sorting['direction'] = request()->direction == 'asc' ? 'desc' : 'asc';
                                                                       @endphp
                                                                       <a href="{{ URL::route('admin.users.index',$sorting) }}">Profile Image</a>
                                                                   </th>

                                                                   <th scope="col">
                                                                    @php
                                                                     $sorting = $qparams;
                                                                     $sorting['sort'] = "first_name";
                                                                     $sorting['direction'] = request()->direction == 'asc' ? 'desc' : 'asc';
                                                                    @endphp
                                                                    <a href="{{ URL::route('admin.users.index',$sorting) }}">Name</a>
                                                                </th>

                                                                <th scope="col">
                                                                        @php
                                                                        $sorting['sort'] = "email";
                                                                       @endphp
                                                                       <a href="{{ URL::route('admin.users.index',$sorting) }}">Email</a>
                                                                </th>
                                                                <th scope="col">
                                                                        @php
                                                                        $sorting['sort'] = "mobileno";
                                                                       @endphp
                                                                       <a href="{{ URL::route('admin.users.index',$sorting) }}">Mobile</a>
                                                                    </th>

                                                                <th scope="col" width="8%">
								       @php
                                                                        $sorting['sort'] = "status";
                                                                       @endphp
                                                                       <a href="{{ URL::route('admin.users.index',$sorting) }}">Status</a></th>

                                                                       <th scope="col" width="8%">@php
                                                                        $sorting['sort'] = "is_verified";
                                                                       @endphp
                                                                       <a href="{{ URL::route('admin.users.index',$sorting) }}">Verify</a></th>
                                                                <th scope="col" width="18%">Created</th>
                                                                <th scope="col" class="actions" width="12%">Actions</th>
                                                            </tr>
                                                        </thead>
                                                                @if($users->count() > 0)
                                                                <tbody>
                                                            @php
                                                            $i = (($users->currentPage() - 1) * ($users->perPage()) + 1)
                                                            @endphp
                                                            @foreach($users as $user)
                                                                <tr class="row-{{ $user->id }}">
                                                                    <td> {{$i}}. </td>
                                                                    <td>
                                                                            @if(!empty($user->profle_photo))
                                                                            <img src="{{ asset(Storage::url($user->profle_photo)) }}" style="width:70px; height:70px;"/>
                                                                            @else
                                                                            <img src="{{ asset('img/default-man.jpg') }}" style="width:70px; height:70px;"/>
                                                                            @endif


                                                                    </td>
                                                                    <td>{{ $user->name }}</td>

                                                                    <td>{{$user->email}}</td>
                                                                    <td>@if($user->mobileno) +61 @endif {{$user->mobileno}}</td>

                                                                    <td>{{  $user->status == 1 ? "Active" : "In-Active" }}</td>
                                                                    <td>{{  $user->is_verified == 1 ? "Verified" : "Not verified" }}</td>
                                                                    <td>{{ $user->created_at->format(config('get.ADMIN_DATE_TIME_FORMAT')) }}</td>
                                                                    <td class="actions">
                                                                        @php
                                                                            $queryStr['id'] = $user->id;
                                                                            //$queryStr = array_merge( $queryStr , $qparams);
                                                                        @endphp
                                                                        <div class="form-group">
                                                                            <a href="{{ route('admin.users.show', $queryStr) }}" class="btn btn-warning btn-sm btn-flat" data-toggle="tooltip" alt="View setting" title="" data-original-title="View"><i class="fa fa-fw fa-eye"></i></a>
                                                                            <a href="{{ route('admin.users.edit', $queryStr) }}" class="btn btn-primary btn-sm btn-flat" data-toggle="tooltip" alt="Edit" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>

                                                                            <a href="javascript:void(0);" class="confirmDeleteBtn btn btn-danger btn-sm btn-flat" data-toggle="tooltip" alt="Delete {{ $user->name }}" data-url="{{ route('admin.users.destroy', $user->id) }}" data-title="Delete {{ $user->first_name }}"><i class="fa fa-trash"></i></a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @php
                                                                $i++;
                                                            @endphp
                                                            @endforeach
                                                            </tbody>
                                                            @else
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan='7' align='center'> <strong>Record Not Available</strong> </td>
                                                                </tr>
                                                            </tfoot>
                                                            @endif
                                                    </table>
                                                </div>
                                        </div>
                                </div>
                        </div>
                        <div class="box-footer clearfix">
                            {{ $users->appends(Request::query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
@stop
