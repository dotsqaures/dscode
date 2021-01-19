
@php
    //$homePageSettings = homePageSettings();
@endphp
@extends('layouts.inner_home')
@section('content')






      <div class="all-devcies-section all-product-inst pad-t70 pad-b70">
        <div class="container">
          <div class="heading text-center">
            <h2>  <span>Others</span></h2>
          </div>
          <div class="three-devies-boxes">
              @if(count($others)>0)
              @foreach($others as $devicess)
            <div class="item devies-box-col">

                    <a href="{{ asset('/models/'.$devicess->slug)}}">

              <div class="white-shad-box devies-box text-center"> <i><img src="{{ asset(Storage::url($devicess->image)) }}" alt=""></i>
                <p>{{ $devicess->device_name }}</p>
              </div>
                    </a>
            </div>
              @endforeach
              @else 
              <p style="text-align:center">No Device found.</p>
              @endif

          </div>
        </div>
      </div>








@include('includes.footer')
@endsection







