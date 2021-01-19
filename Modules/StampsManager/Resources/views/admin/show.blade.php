@extends('layouts.admin.master')
@section('title','View Stamp Cards Detail')
@section('content')
@include('layouts.admin.flash.alert')
<section class="content-header">
    <h1>
        Manage Stamp
        <small>Here you can view stamp card details</small>
    </h1>
    {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.stamps.index'],['label' => 'View Restaurent Details']]]) }}
</section>
@php $calendar_type=[1=>'OutLook',2=>'Gmail',3=>'Yahoo',4=>'Mac(thunderbird)']; @endphp
<section class="content" data-table="emailHooks">
    <div class="box">
        <div class="box-header"><h3 class="box-title">{{ $restro->title }}</h3>
            {{-- <a href="{{ route('admin.users.index', app('request')->query()) }}" class="btn btn-default pull-right" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a> --}}

            <div class="box-body">
                <table class="table table-hover table-striped">

                    <tr>
                        <th scope="row">{{ __('Status') }}</th>
                        <td>{{ $restro->status ? __('Active') : __('Inactive')  }}</td>
                    </tr>

                        <tr>
                                <th scope="row">{{ __('How Many Stamps') }}</th>
                                <td>{{ $restro->stemp_no }}</td>
                            </tr>


                            <tr>
                                <th scope="row">{{ __('valid Till') }}</th>
                                <td>{{ $restro->stemp_valid }}</td>
                            </tr>

                            <tr>
                                <th scope="row">{{ __('Normal Price') }}</th>
                                <td>{{ $restro->normal_price }}</td>
                            </tr>

                            <tr>
                                <th scope="row">{{ __('Discount Price') }}</th>
                                <td>{{ $restro->descoun_price }}</td>
                            </tr>



                            <tr>
                                <th scope="row">{{ __('Short Description') }}</th>
                                <td>{{ $restro->short_description }}</td>
                            </tr>

                            <tr>
                                <th scope="row">{{ __('Description') }}</th>
                                <td>{{ $restro->description }}</td>
                            </tr>




                      <tr>
                            <th scope="row"><?= __('Created') ?></th>
                            <td>{{ $restro->created_at->format(config('get.ADMIN_DATE_TIME_FORMAT')) }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('Modified') }}</th>
                            <td>{{ $restro->updated_at->format(config('get.ADMIN_DATE_TIME_FORMAT')) }}</td>
                        </tr>

                        @if(!empty($restro->stamp_picture))
                        <tr>
                            <th scope="row"><?= __('Stamp Image') ?></th>
                            <td>

                          <img src="{{ asset(Storage::url($restro->stamp_picture)) }}" style="width:100px; height:100px;"/>

                            </td>
                        </tr>
                        @endif


                    </table>

            </div>
            <div class="box-footer">
                <a href="{{route('admin.stamps.index', app('request')->query())}}" class="btn btn-default pull-left" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
            </div>
        </div>
    </div>


    </section>

@endsection
