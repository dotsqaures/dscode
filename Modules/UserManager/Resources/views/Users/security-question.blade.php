@extends('layouts.common')
@section('title','Manage Profile')
@section('content')
<div class="left-panel ">

    <div class="heading heading-group text-center text-uppercase">
        <h1>Security Questions </h1>
        <a class="back-btn" href="{{ route('dashboard') }}"><img src="images/back-btn.png" alt=""></a>
    </div>

    <div class="scrollbox">
        <div class="form-part">
    @include('layouts.admin.flash.alert')
            <div class="login-box pad1">

                {{ Form::model($user, ['url' => route('update-security-question') , 'method' => 'patch','enctype'=>'multipart/form-data','autocomplete' => 'off']) }}

                <div id="accordion" class="accordion-block">
                        {{-- @if($user_security_questions->count()<=0) --}}

                    <div class="card">
                      <div class="card-header">
                        <a class="card-link" data-toggle="collapse" href="#collapseOne" aria-expanded="true">Security QA-1</a>
                      </div>
                      <div id="collapseOne" class="collapse show" data-parent="#accordion">
                        <div class="card-body">
                          <div class="form-group position-relative {{ $errors->has('security_questions.0') ? 'has-error' : '' }}"> <i class="iconimg"><img alt="" src="images/icon15.png"></i>
                             {!! Form::select('security_questions[0]', $security_questions->pluck('title', 'id'), old('security_questions.0') ? old('security_questions.0') : ($myans[0]['question_id'] ?? null) , ['required'=>'required','class'=>'seq-qst form-control']) !!}
                             <span class="help-block"> {{ $errors->first('security_questions.0', ':message') }} </span>
                            </div>
                          <div class="form-group position-relative {{ $errors->has('security_answers.0') ? 'has-error' : '' }}"> <i class="iconimg"><img alt="" src="images/icon16.png"></i>
                            {!! Form::text('security_answers[0]', old('security_answers.0') ? old('security_answers.0') : ($myans[0]['security_answers'] ?? null), ['placeholder' => 'Security answer', 'required'=>'required','class'=>'form-control']) !!}
                            <span class="help-block"> {{ $errors->first('security_answers.0', ':message') }} </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                            <div class="card-header">
                              <a class="card-link" data-toggle="collapse" href="#collapseTwo" >Security QA-2</a>
                            </div>
                            <div id="collapseTwo" class="collapse " data-parent="#accordion">
                                    <div class="card-body">
                                            <div class="form-group position-relative {{ $errors->has('security_questions.1') ? 'has-error' : '' }}"> <i class="iconimg"><img alt="" src="images/icon15.png"></i>
                                               {!! Form::select('security_questions[1]', $security_questions->pluck('title', 'id'),old('security_questions.1') ? old('security_questions.1') : ($myans[1]['question_id'] ?? null), ['required'=>'required','class'=>'seq-qst form-control']) !!}
                                               <span class="help-block"> {{ $errors->first('security_questions.1', ':message') }} </span>
                                              </div>
                                            <div class="form-group position-relative {{ $errors->has('security_answers.1') ? 'has-error' : '' }}"> <i class="iconimg"><img alt="" src="images/icon16.png"></i>
                                              {!! Form::text('security_answers[1]', old('security_answers.1') ? old('security_answers.1') : ($myans[1]['security_answers'] ?? null), ['placeholder' => 'Security answer', 'required'=>'required','class'=>'form-control']) !!}
                                              <span class="help-block"> {{ $errors->first('security_answers.1', ':message') }} </span>
                                            </div>
                                          </div>
                            </div>
                          </div>
                          <div class="card">
                                <div class="card-header">
                                  <a class="card-link" data-toggle="collapse" href="#collapseThree" >Security QA-3</a>
                                </div>
                                <div id="collapseThree" class="collapse " data-parent="#accordion">
                                        <div class="card-body">
                                                <div class="form-group position-relative {{ $errors->has('security_questions.2') ? 'has-error' : '' }}"> <i class="iconimg"><img alt="" src="images/icon15.png"></i>
                                                   {!! Form::select('security_questions[2]', $security_questions->pluck('title', 'id'), old('security_questions.2') ? old('security_questions.2') : ($myans[2]['question_id'] ?? null), ['required'=>'required','class'=>'seq-qst form-control']) !!}
                                                   <span class="help-block"> {{ $errors->first('security_questions.2', ':message') }} </span>
                                                  </div>
                                                <div class="form-group position-relative {{ $errors->has('security_answers.2') ? 'has-error' : '' }}"> <i class="iconimg"><img alt="" src="images/icon16.png"></i>
                                                  {!! Form::text('security_answers[2]', old('security_answers.2') ? old('security_answers.2') : ($myans[2]['security_answers'] ?? null), ['placeholder' => 'Security answer', 'required'=>'required','class'=>'form-control']) !!}
                                                  <span class="help-block"> {{ $errors->first('security_answers.2', ':message') }} </span>
                                                </div>
                                              </div>
                                </div>
                              </div>

                  </div>
                  <div class="form-group btn-top ">
                    <div class="login-btn  ">
                      <button type="submit" class="btn btn-black hvr-shutter-out-horizontal">UPDATE NOW</button>
                    </div>
                  </div>
                {{ Form::close() }}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>


@stop

@section('per_page_style')
@stop
@section('script_per_page')
<script>
    $(document).ready(function(){
        $('#accordion .collapse').removeAttr("data-parent");
        $('#accordion .collapse').collapse('show');
        $('#accordion .collapse').attr("data-parent","#accordion");

    });
</script>

@stop
