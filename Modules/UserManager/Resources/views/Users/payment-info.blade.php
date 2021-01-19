@extends('layouts.common')
@section('title','Manage Profile')
@section('content')
<div class="left-panel ">
    <div class="heading heading-group text-center text-uppercase">
        <h1>Payment Account Info
             {{-- ({{ $authUser->id }}) --}}
            </h1>
        <a class="back-btn" href="{{ route('dashboard') }}"><img src="{{ asset('images/back-btn.png') }}" alt=""></a>
    </div>
    <div class="scrollbox">
        <div class="form-part">
                @include('layouts.admin.flash.alert')
            <div class="login-box pad1">

                {{ Form::model($user, ['url' => route('update-password-account') ,'enctype'=>'multipart/form-data', 'method' => 'post']) }}
                <div id="accordion" class="accordion-block">


                        <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseOne">Payment Account Information</a>
                                </div>
                                <div id="collapseOne" class="collapse" data-parent="#accordion">
                                    <div class="card-body">

                                            <div class="form-group position-relative  {{ $errors->has('routing_number') ? 'has-error' : '' }}"> <i class="iconimg"><img alt="" src="images/icon2.png"></i>
                                            {{ Form::text('routing_number', old('routing_number') ? old('routing_number') : ($user->profile ? $user->profile->routing_number : '') ,
                                                ['class' => 'form-control','placeholder' => 'Routing Number']) }} @if($errors->has('routing_number'))
                                                <span class="help-block">{{ $errors->first('routing_number') }}</span> @endif
                                            </div>

                                            <div class="form-group position-relative  {{ $errors->has('account_number') ? 'has-error' : '' }}"> <i class="iconimg"><img alt="" src="images/icon2.png"></i> {{ Form::text('account_number', old('account_number') ? old('account_number') : ($user->profile ? $user->profile->account_number : ''),
                                                ['class' => 'form-control','placeholder' => 'Account Number']) }} @if($errors->has('account_number'))
                                                <span class="help-block">{{ $errors->first('account_number') }}</span> @endif
                                            </div>

                                            <div class="form-group position-relative  {{ $errors->has('ssn_last_4') ? 'has-error' : '' }}"> <i class="iconimg"><img alt="" src="images/icon2.png"></i> {{ Form::text('ssn_last_4', old('ssn_last_4') ? old('ssn_last_4') :($user->profile ? $user->profile->ssn_last_4 : ''),
                                                ['class' => 'form-control','placeholder' => 'Last 4 digits of SSN']) }} @if($errors->has('ssn_last_4'))
                                                <span class="help-block">{{ $errors->first('ssn_last_4') }}</span> @endif
                                            </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">ID Document</a>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                                <div class="form-group">
                                                <p><strong> Requirements for ID verification.</strong> </p>
                                                <p> Acceptable documents vary by country, although a passport scan is always acceptable and preferred.</p>
                                                <p> Scans of both the front and back are usually required for government-issued IDs and driver’s licenses.</p>
                                                <p> Files need to be JPEGs or PNGs smaller than 5MB. We can’t verify PDFs.</p>
                                                        <p> Files should be in color, be rotated with the image right-side up, and have all information clearly legible.
                                                </p>
                                                </div>
                                                <div class="form-group position-relative {{ $errors->has('stripe_document_front') ? 'has-error' : '' }}">
                                                    <label style="display:block;">Verification Document Front</label>
                                                        <input class="" type="file" name="stripe_document_front" />
                                                        @if($errors->has('stripe_document_front'))
                                                        <span style="display:block" class="help-block">{{ $errors->first('stripe_document_front') }}</span> @endif
                                                        @php
                                               $filepath = '/storage/users/doc/';
                                               @endphp
                                               @if(!empty($user->profile->stripe_document_front) && file_exists(public_path() . $filepath . $user->profile->stripe_document_front)) <a href="{{ url($filepath. $user->profile->stripe_document_front) }}" download>download</a>
                                                       @endif
                                                    </div>

                                                    <div class="form-group position-relative {{ $errors->has('stripe_document_back') ? 'has-error' : '' }}">
                                                            <label style="display:block;">Verification Document Back</label>
                                                                <input class="" type="file" name="stripe_document_back" />
                                                                @if($errors->has('stripe_document_back'))
                                                                <span style="display:block" class="help-block">{{ $errors->first('stripe_document_back') }}</span> @endif
                                                                @php
                                                       $filepath = '/storage/users/doc/';
                                                       @endphp


                                                       @if(!empty($user->profile->stripe_document_back) && file_exists(public_path() . $filepath . $user->profile->stripe_document_back)) <a href="{{ url($filepath. $user->profile->stripe_document_back) }}" download>download</a>
                                                               @endif
                                                            </div>


                                        </div>
                                    </div>
                                </div>



                </div>
                <div class="form-group btn-top ">
                    <div class="login-btn  ">
                        <button type="submit" class="btn btn-black hvr-shutter-out-horizontal">Update Info</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@stop
@section('script_per_page')
<script>
    @if(!empty($errors->all()))
    // $('.collapse:not(".in")')
    // .collapse('show');
    //$('#accordion .collapse').collapse('hide');
    $('#accordion .collapse').removeAttr("data-parent");
    $('#accordion .collapse').collapse('show');
    $('#accordion .collapse').attr("data-parent","#accordion");
    @endif
    </script>

@stop
