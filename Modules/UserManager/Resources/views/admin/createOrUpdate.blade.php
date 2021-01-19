@extends('layouts.admin.master')

@section('content')
@include('layouts.admin.flash.alert')

<!-- Content Header (user header) -->
<section class="content-header">
<style>
.phone-no {
    position: absolute;
    left: 0;
    height: 100%;
    display: flex;
    -webkit-display: flex;
    justify-content: center;
    -webkit-justify-content: center;
    align-items: center;
    -webkit-align-items: center;
    background: #fff;
    border-radius: 4px 0 0 4px;
    color: #000;
    width: 45px;
    border-right: 1px solid #e0e0e0;
}
.phone-no-outer {
    position: relative;
    background-color: #f5f5f5 !important;
    border-color: #e0e0e0 !important;
    padding-left: 45px;
    border: 1px solid;
    border-radius: 4px;
}
.phone-no-outer .form-control{
border: none;
}
</style>
    <h1>
        Manage employee
        <small>Here you can manage employee user </small>
    </h1>
    {{ Breadcrumbs::render('common',['append' => [['label'=> $getController,'route'=> 'admin.users.index'],['label' => !empty($user) ? 'Edit user' : 'Add Users' ]]]) }}
</section>
<section class="content" data-table="users">
    <div class="row users">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> </h3>
                    <a href="{{ route('admin.users.index', app('request')->query()) }}" class="btn btn-default pull-right" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                </div><!-- /.box-header -->

                @if(isset($user))
                @php
                $queryStr['id'] = $user->id;
                $queryStr = array_merge( $queryStr , app('request')->query());
                @endphp
                {{ Form::model($user, ['url' => route('admin.users.update', $queryStr) , 'method' => 'patch','enctype'=>'multipart/form-data']) }}
                @else
                {{ Form::open(['url' => route('admin.users.store', app('request')->query()),'enctype'=>'multipart/form-data']) }}
                @endif
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="form-group required {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="first_name">Employee Name</label>
                                    <div class="col-md-6">
                                        {{ Form::text('first_name', old('first_name'), ['class' => 'form-control','placeholder' => 'First Name']) }}

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="last_name">4 digit employee code</label>
                                    <div class="col-md-6">
                                        {{ Form::number('employee_code', old('employee_code'), ['class' => 'form-control','placeholder' => 'Employee 4 digit code',"maxlength"=>4]) }}

                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="email">Email</label>
                                    <div class="col-md-6">
                                        {{ Form::text('email', old('email'), ['type' => 'email','class' => 'form-control','placeholder' => 'Email']) }}

                                    </div>
                                </div>
                            </div>


                            <div class="form-group required {{ $errors->has('restuarents_id') ? 'has-error' : '' }}">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="device_type">Restaurent</label>
                                    <div class="col-md-6">
                                        {{ Form::select('restuarents_id', $restro, old("restuarents_id"), ['class' => 'form-control']) }}
                                        @if($errors->has('restuarents_id'))
                                        <span class="help-block">{{ $errors->first('restuarents_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>



                            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="last_name">Status</label>
                                    <div class="col-md-6">
                                        {{ Form::select('status', [1 => 'Active', 0 => 'Inactive'], old("status"), ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>







                            <!--<div class="form-group {{ !empty($user) ? '' : 'required' }} {{ $errors->has('password') ? 'has-error' : '' }}">
                                <div class="row">
                                    <label class="col-md-3 control-label" for="password">Password</label>
                                    <div class="col-md-6">
                                            {{ Form::password('password', ['class' => 'form-control','placeholder' => 'Password']) }}
                        @if($errors->has('password'))
                                        <span class="help-block">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ !empty($user) ? '' : 'required' }} {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            <div class="row">
                                <label class="col-md-3 control-label" for="last_name">Confirm Password</label>
                                <div class="col-md-6">
                                    {{ Form::password('password_confirmation', ['class' => 'form-control','placeholder' => 'Confirm Password']) }}
                                    @if($errors->has('password_confirmation'))
                                    <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>-->






                        @if(!empty($user->profle_photo))
                          <img src="{{ asset(Storage::url($user->profle_photo)) }}" style="width:100px; height:100px;"/>
                          @endif


                          <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label" for="last_name">Profile Image</label>
                                <div class="col-md-6">
                                    {{ Form::file('profle_photo', null, array('id' => 'image', 'class' => 'custom-file-control', 'placeholder' => '')) }}
                                    @if($errors->has('profle_photo'))
                                    <span class="help-block" style="color:red;">Only jpg,png,gif image type allow</span>
                                    @endif
                                </div>

                            </div>
                        </div>




                                            {{-- <div class="form-group required {{ $errors->has('roles') ? 'has-error' : '' }                                        }">
                                    <div class="ro                                            w">
                                        <label class="col-md-3 control-label" for="first_name">User Roles</lab                                            el>
                                        <div clas                                            s="col                                            -md-                                                6">
                                             {{Form::select('roles[]',$roles, !isset($user->id) ? app('request')->query('role') : null,['multiple'=>'multiple', 'class'=> 'form-control']                                                                                                                                            )}}
                                            @if($errors->has('roles                                                                                                                            '))
                                            <span class="help-block">{{ $errors->first('roles') }}</span>
                                                                            @endif
                                                                        </div>
                                                                </div>
                                                            </div> --}}

                                                        </div>
                                                </div> <!-- /.row -->
                                            </div><!-- /.box-body -->
                                            <div class="box-footer">
                                                <button class="btn btn-primary btn-flat" title="Submit" type="submit"><i class="fa fa-fw fa-save"></i> Submit</button>
                                                <a href="{{ route('admin.users.index', app('request')->query()) }}" class="btn btn-warning btn-flat" title="Back"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
                                            </div>
                                            {{ Form::close() }}

                                        </div>
                                </div>
                            </div>
                            </section>
                            @stop
@section('per_page_script')
<script>

// This sample uses the Autocomplete widget to help the user select a
// place, then it retrieves the address components associated with that
// place, and then it populates the form fields with those details.
// This sample requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete;
var componentForm = {
street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        // country: 'long_name',
        //postal_code: 'short_name'
};
function initAutocomplete() {
// Create the autocomplete object, restricting the search predictions to
// geographical location types.
autocomplete = new google.maps.places.Autocomplete(document.getElementById('full_address'), {types: ['geocode']});
autocomplete.setFields(['address_components', 'geometry']);
autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
var place = autocomplete.getPlace();
for (var component in componentForm) {
console.log(component);
document.getElementById(component).value = '';
document.getElementById(component).disabled = false;
}

console.log(autocomplete.getPlace());
if (place != undefined) {
var lat = place.geometry.location.lat();
var lng = place.geometry.location.lng();
document.getElementById("latitude").value = lat;
document.getElementById("longitude").value = lng;
for (var i = 0; i < place.address_components.length; i++) {
var addressType = place.address_components[i].types[0];
if (componentForm[addressType]) {
    var val = place.address_components[i][componentForm[addressType]];
    document.getElementById(addressType).value = val;
    }
}
}
}

// Bias the    autocomplete obje    ct to the user's geographical location,
// as supplied by the browser's 'navigator.geolocatio                n' obje            ct.
function geolocate(){
if (navigator.geolocation) {
navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
    var circle = new google.maps.Circle({center: geolocation, radius: position.coords.accuracy});
        autocomplete.setBounds(circle.getBounds());
    });
}
}

$('#full_address').keypress(function (e) {
    if (e.which == 13) {
        google.maps.event.trigger(autocomplete, 'place_changed');
        return false;
    }
});
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXZKrj9Z9SBgjD1E9CTk5f4d5rh0Mwvcc&libraries=places&callback=initAutocomplete"
    async defer></script>


        {{ Html::script('js/jquery.mask.js') }}

        <script>
                $(document).ready(function($){

                $(".jbsekerregis").mask("400 000 000");
                });
        </script>

    @stop
