@extends('layouts.inner_home')
@section('title','Recenlty View')
@section('content')


<div class="middle-wrapper ">
    <div class="container">
    <div class=" pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>My  <span>Recently Viewed List</span></h1>
    </div>
    @include('layouts.admin.flash.alert')

    <div class="d-flex justify-content-end">
            {{ $recenltyviews->links() }}
    </div>

    </div>


    <div class="product-lists mrg-t20">
    <div class="row">

    <div class="col-sm-12">
        <a class="product-search dekstop-tab-hide" href="javascript:void(0)" onClick="expandfullscreenmenu('open')">
            <i class="fas fa-bars"></i>Menus </a>
    </div>

    <div class="col-md-4 product-category-col ">
    <input type="checkbox" id="togglebox" class="togglebox dekstop-tab-hide" />
    <nav id="expand-fullpagemenu">

    <label for="togglebox" id="closex" class="toggleclose dekstop-tab-hide">Close</label>

    <div class="product-category-box shad my-product-col">

            @include('layouts.sidebar')


    </div>

  </nav>

    </div>

 <div class="col-md-8 product-showcase grid-view-product my-product-lists ">

 <div class="row">

        @if(count($recenltyviews)>0)
        @foreach($recenltyviews as $views)

              <div class="col-lg-4 col-sm-6 listing-product-col">
                <div class="listing-box">
                        <div class="listing-phone-box">


                           <?php

                           $productimages = \App\Helpers\BasicHelpers::getproductimages($views->product_id);

                                if(!empty($views['product']['mainphoto'])){ ?>


                               <a href="javascript:void(0)"><img src="{{ asset(Storage::url($views['product']['mainphoto'])) }}" alt=""></a>

                               <?php } else{ ?>

                                 <a href="javascript:void(0)"><img src="{{ asset('img/NoPhone_grande.png') }}" alt=""></a>

                              <?php } ?>


                            </div>
                  <div class="view-detail-btn"><a href="{{ url('product/'.$views['product']['product_slug'])}}" class="blue-btn btn">VIEW DETAILS</a></div>
                 <div class="product-details text-center">


                    <h2>{{ $views['product']['item_title'] }}</h2>

                    <div class="product-price"><span>$</span>{{ $views['product']['final_price'] }}</div>
                  </div>




              </div>
              </div>


              @endforeach

              @else
              <div class="col-lg-6 col-sm-6 listing-product-col">

             <p>Recently viewed list not found. Kindly <a href="{{ asset('/') }}" style="color:blue">browse</a> products as per your interest</p>
                    </div>
              @endif




            </div>

            <div class="d-flex justify-content-end">
                    {{ $recenltyviews->links() }}
            </div>



    </div>


    </div>
    </div>









    </div>




    </div>

    </div>

    {{ Html::style('css/star.css') }}

    {{ Html::script('js/star-rating.js') }}
    {{ Html::style('css/star-boot.css') }}


{{ Html::script('js/star-rating-min.js') }}




<style>



          .rating-container .clear-rating{display:none !important}
          .rating-container .caption{display:none !important}
          .rating-xs { font-size: 1.0em !important;}
          .rating-container .filled-stars {
              position: absolute;
              left: 0;
              top: 0;
              margin: auto;
              color: #ffb400 !important;
              white-space: nowrap;
              overflow: hidden;
              -webkit-text-stroke: 1px #ffb400 !important;
            text-shadow: none !important;
          }

  </style>





@include('includes.footer')
@endsection






