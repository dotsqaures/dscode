@extends('layouts.common')
@section('title','Manage Profile')
@section('content')
<div class="left-panel ">
    <div class="heading heading-group text-center text-uppercase">
        <h1>Licence Documents
             {{-- ({{ $authUser->id }}) --}}
            </h1>
        <a class="back-btn" href="{{ route('dashboard') }}"><img src="{{ asset('images/back-btn.png') }}" alt=""></a>
    </div>
    <div class="scrollbox">
        <div class="form-part">
                @include('layouts.admin.flash.alert')
            <div class="login-box pad1">

                {{ Form::model($user, ['url' => route('user.post-licence') ,'enctype'=>'multipart/form-data', 'method' => 'post']) }}
                <div id="accordion" class="accordion-block">
                            <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">Document</a>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                        <div class="card-body">

                                                <div class="form-group position-relative {{ $errors->has('state_licence') ? 'has-error' : '' }}">
                                                    <label style="display:block;">State Licence</label>
                                                        <input class="" type="file" name="state_licence" />
                                                        @if($errors->has('state_licence'))
                                                        <span style="display:block" class="help-block">{{ $errors->first('state_licence') }}</span> @endif
                                                        @php
                                                        $filepath = '/storage/users/doc/';
                                                        @endphp
                                               @if(!empty($user->profile->state_licence) && file_exists(public_path() . $filepath . $user->profile->state_licence)) <a href="{{ url($filepath. $user->profile->state_licence) }}" download>download</a>
                                                       @endif


                                                    </div>

                                                    <div class="form-group position-relative {{ $errors->has('dealer_registration') ? 'has-error' : '' }}">
                                                            <label style="disply:block;">Dealer Registration</label>
                                                                <input class="" type="file" name="dealer_registration" />
                                                                @if($errors->has('dealer_registration'))
                                                                <span style="display:block" class="help-block">{{ $errors->first('dealer_registration') }}</span> @endif
                                                                @php
                                                       $filepath = '/storage/users/doc/';
                                                       @endphp
                                                       @if(!empty($user->profile->dealer_registration) && file_exists(public_path() . $filepath . $user->profile->dealer_registration)) <a href="{{ url($filepath. $user->profile->dealer_registration) }}" download>download</a>
                                                               @endif
                                                   </div>

                                                   <div class="form-group position-relative {{ $errors->has('retail_licence') ? 'has-error' : '' }}">
                                                        <label style="display:block;">Retail Licence</label>
                                                            <input class="" type="file" name="retail_licence" />
                                                            @if($errors->has('retail_licence'))
                                                            <span style="display:block" class="help-block">{{ $errors->first('retail_licence') }}</span> @endif
                                                            @php
                                                   $filepath = '/storage/users/doc/';
                                                   @endphp
                                                   @if(!empty($user->profile->retail_licence) && file_exists(public_path() . $filepath . $user->profile->retail_licence)) <a href="{{ url($filepath. $user->profile->retail_licence) }}" download>download</a>
                                                           @endif
                                               </div>

                                        </div>
                                    </div>
                                </div>



                </div>
                <div class="form-group btn-top ">
                    <div class="login-btn  ">
                        <button type="submit" class="btn btn-black hvr-shutter-out-horizontal">Upload</button>
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
    $('#accordion .collapse').removeAttr("data-parent");
    $('#accordion .collapse').collapse('show');
    $('#accordion .collapse').attr("data-parent","#accordion");
</script>

@stop
