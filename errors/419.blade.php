@extends('errors::layout')
@section('title', __('Not Found'))
@section('content')

<div class="middle-wrapper">
    <div class="container">

            <div class="error-page">
                    <div class="cart-dtl-box shad">
                      <img src="{{ asset('img/error.png') }}" alt=""/>
                      <h2 class="pb-0">Error</h2>
                      <h2>Sorry, The Page Has been Expired</h2>
                      <p>The page you are looking for ways moved, removed, renamed or might never existed.</p>
                      <a href="{{ app('router')->has('frontend.home') ? route('frontend.home') : url('/') }}" class="btn-custom">Go home</a>
                    </div>
                  </div>

    </div>
  </div>

