@extends('layouts.inner_home')
@section('title','Product')
@section('content')


<div class="middle-wrapper ">
    <div class="container">
    <div class=" pad-t40 pad-b40">
    <div class="d-flex align-items-center justify-content-between title-heading">
    <div class="heading">
    <h1>My  <span>Watch List</span></h1>
    </div>
    @include('layouts.admin.flash.alert')

    <div class="d-flex justify-content-end">
            {{ $Product->links() }}
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

        @if(count($Product)>0)
        @foreach($Product as $product)

              <div class="col-lg-4 col-sm-6 listing-product-col">
                <div class="listing-box">
                        <div class="listing-phone-box">
    
                              @if(!empty($product['productsdata']['mainphoto']))
                              <a  href="javascript:void(0)"><img src="{{ asset(Storage::url($product['productsdata']['mainphoto'])) }}" /></a>
                             @else
                             <a href="javascript:void(0)"><img src="{{ asset('img/NoPhone_grande.png') }}"/></a>
                             @endif


                            </div>
                  <div class="view-detail-btn"><a href="{{ url('product/'.$product['productsdata']['product_slug'])}}" class="blue-btn btn">VIEW DETAILS</a></div>
                 <div class="product-details text-center">
                  <div class="product-message">
                      @php
                     $messageCount = \App\Helpers\BasicHelpers::CountUnreadMessage($product['productsdata']['id'],$logInedUser->id);
                      @endphp
                  <a href="{{ url('message/'.$product['productsdata']['id'])}}"><i><img src="{{ asset('img/message_icon.png')}}" alt=""></i>
                  Messages <span class="unread-message">

                    @php
                    if($messageCount > 0)

                    echo  '('.$messageCount.')';

                    @endphp

                </span></a>

                  </div>
                    <div class="star-rating ">
                            <input id="input-2" name="star_ratting" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $product['productsdata']['star_ratting'] }}" data-size="xs" disabled="">
                    </div>
                    <h2>{{ $product['productsdata']['item_title'] }}</h2>
                    <p>{{ substr($product['productsdata']['item_description'], 0, 45) . '...' }}</p>
                    <div class="product-price"><span>$</span>{{ $product['productsdata']['final_price'] }}</div>
                  </div>




              </div>
              </div>


              @endforeach

              @else
              
               <div class="col-lg-12 col-sm-12  order-block">
            <div class="top-block d-flex align-items-center flex-wrap justify-content-between">
              <div class="top-block-left">
                  <span class="text-uppercase">There are no items in your watch list.</span>
              </div>

            </div>
        </div>
            
              @endif




            </div>

            <div class="d-flex justify-content-end">
                    {{ $Product->links() }}
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






