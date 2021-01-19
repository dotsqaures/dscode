@extends('layouts.admin.master')
@section('title','View Restaurent Detail')
@section('content')
@include('layouts.admin.flash.alert')
<section class="content-header">
    <h1>
        Manage Restaurant
        <small>Here you can view restaurant details</small>
    </h1>
    {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.restaurents.index'],['label' => 'View Restaurent Details']]]) }}
</section>
@php $calendar_type=[1=>'OutLook',2=>'Gmail',3=>'Yahoo',4=>'Mac(thunderbird)']; @endphp
<section class="content" data-table="emailHooks">
    <div class="box">
        <div class="box-header"><h3 class="box-title">{{ $restro->name }}</h3>
            {{-- <a href="{{ route('admin.users.index', app('request')->query()) }}" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a> --}}

            <div class="box-body">
                <table class="table table-hover table-striped">


                        <tr>
                                <th scope="row">{{ __('Location') }}</th>
                                <td>{{ $restro->location }}</td>
                            </tr>

                            <tr>
                                <th scope="row">{{ __('Latitude') }}</th>
                                <td>{{ $restro->lat }}</td>
                            </tr>

                            <tr>
                                <th scope="row">{{ __('Longitude') }}</th>
                                <td>{{ $restro->lng }}</td>
                            </tr>



                            <tr>
                                <th scope="row">{{ __('Description') }}</th>
                                <td>{{ $restro->desciption }}</td>
                            </tr>




                      <tr>
                            <th scope="row"><?= __('Created') ?></th>
                            <td>{{ $restro->created_at->format(config('get.ADMIN_DATE_TIME_FORMAT')) }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Modified') }}</th>
                            <td>{{ $restro->updated_at->format(config('get.ADMIN_DATE_TIME_FORMAT')) }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Status') }}</th>
                            <td>{{ $restro->status ? __('Active') : __('Inactive')  }}</td>
                        </tr>


                        @if(!empty($restro->restro_picture))
                        <tr>
                            <th scope="row"><?= __('Restaurant Image') ?></th>
                            <td>

                          <img src="{{ asset(Storage::url($restro->restro_picture)) }}" style="width:100px; height:100px;"/>

                            </td>
                        </tr>
                        @endif

                    </table>

@if(count($restro->restaurantTime)>0)


                    <table class="table table-hover table-striped">
                        <th>SNO</th>
                        <th>Day</th>
                        <th>Morning Open/Close Time</th>
                        <th>Evening Open/Close Time</th>
                 @foreach($restro->restaurantTime as $timess)
                        <tr>
                            <td>1</td>
                            <td>{{ $timess->week_day }}</td>
                            <td>{{ $timess->morning_open_time.'-'.$timess->morning_close_time }}</td>
                            <td>{{ $timess->evening_open_time.'-'.$timess->evening_close_time }}</td>
                        </tr>
                        @endforeach
                    </table>

                  @endif

            </div>

            <div class="box-footer">
                <a href="{{route('admin.restaurents.index', app('request')->query())}}" class="btn btn-default pull-left" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
            </div>
        </div>
    </div>


    </section>

@endsection
