@extends('layouts.admin.master')
@section('title','View User Detail')
@section('content')
@include('layouts.admin.flash.alert')
<section class="content-header">
    <h1>
        Manage User
        <small>Here you can view user details</small>
    </h1>
    {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.users.index'],['label' => 'View user Details']]]) }}
</section>
@php $calendar_type=[1=>'OutLook',2=>'Gmail',3=>'Yahoo',4=>'Mac(thunderbird)']; @endphp
<section class="content" data-table="emailHooks">
    <div class="box">
        <div class="box-header"><h3 class="box-title">{{ $user->name }}</h3>
            {{-- <a href="{{ route('admin.users.index', app('request')->query()) }}" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a> --}}

            <div class="box-body">
                <table class="table table-hover table-striped">


                        <tr>
                                <th scope="row">{{ __('Full Name') }}</th>
                                <td>{{ $user->first_name.' '.$user->last_name }}</td>
                            </tr>



                        <tr>
                            <th scope="row">{{ __('Email') }}</th>
                            <td>{{ $user->email }}</td>
                        </tr>

                        <tr>
                            <th scope="row">{{ __('Mobile') }}</th>
                            <td>{{ $user->mobileno }}</td>
                        </tr>



                      <tr>
                            <th scope="row"><?= __('Created') ?></th>
                            <td>{{ $user->created_at->format(config('get.ADMIN_DATE_TIME_FORMAT')) }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Modified') }}</th>
                            <td>{{ $user->updated_at->format(config('get.ADMIN_DATE_TIME_FORMAT')) }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Status') }}</th>
                            <td>{{ $user->status ? __('Active') : __('Inactive')  }}</td>
                        </tr>

                        @if(!empty($user->profle_photo))
                        <tr>
                            <th scope="row">{{ __('Profile Image') }}</th>
                            <td> <img src="{{ asset(Storage::url($user->profle_photo)) }}" style="width:100px; height:100px;"/></td>
                        </tr>
                        @endif

                    </table>

            </div>
            <div class="box-footer">
                <a href="{{  URL::previous() }} " class="btn btn-default pull-left" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
            </div>
        </div>
    </div>


    </section>

@endsection
