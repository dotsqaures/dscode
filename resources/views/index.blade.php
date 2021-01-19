
@php
//$homePageSettings = homePageSettings();
@endphp
@extends('layouts.home')
@section('content')


<div class="mainbanner">
    <div class="container">
        <!--<div class="d-flex justify-content-between align-items-center banner-area">
          <div class="main-bannertext"> <span class="banner-content1">We Pay You The Price</span>
            <div class="banner-content2">We QUOTE!</div>
            <ul class="bannertag-point">
              <li><a href="javascript:void(0)">NO TRICKS</a></li>
              <li><a href="javascript:void(0)">NO GIMMICKS</a></li>
            </ul>
          </div>
          <div class="banner-phone"><img src="{{ asset('storage/settings/' . config('get.home-banner-image')) }}" alt=""></div>
        </div>-->
        <div class="d-block banner-ads">
            <img src="../img/banner-ads.png" alt="">
        </div>
        <div class="d-block divice-sec">
            <div class="row">
                <div class="col-md-4">
                    <figure class="divice-img"><img src="{{ asset('img/iPhone10.png') }}" alt=""></figure>
                    <div class="d-block">
                        <a href="models/iPhones" class="btn-cat buy-divice">BUY<i class="fas fa-arrow-circle-right"></i></a>
                        <p>Great deals for latest pre-owned devices</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <figure class="divice-img"><img src="{{ asset('img/cracked-iphone-7.png') }}" alt=""></figure>
                    <div class="d-block">
                        <a href="http://www.sellmybrokenphone.com.au/" class="btn-cat trade-in" target="_blank">TRADE IN<i class="fas fa-arrow-circle-right"></i></a>
                        <p>Have a broken, non-working iPhone? We buy used iPhones too!</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <figure class="divice-img"><img src="{{ asset('img/iPhone7.png') }}" alt=""></figure>
                    <div class="d-block">
                        <a href="addProduct" class="btn-cat sell-divice">SELL<i class="fas fa-arrow-circle-right"></i></a>
                        <p>Got an old device of value lying around the house? Sell it directly to a buyer</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-block text-center">
            <h2>Why Choose Us</h2>
            <div class="row">
                <div class="col-md-4">
                    <h3>Better Deals</h3>
                    <p>Selling your device directly to another user and cutting out the middleman means you get the best deal and highest value.</p>
                </div>
                <div class="col-md-4">
                    <h3>Secured Transactions</h3>
                    <p>Using the Stripe payment platform, our buyers and sellers remain protected and can trade with confidence!
                    </p>
                </div>
                <div class="col-md-4">
                    <h3>No Junk filter</h3>
                    <p>We only allow working devices to be sold on our platform.*Each device listed by a seller must meet our criteria before it is manually approved by our team.</p>
                </div>
            </div>
        </div>

    </div>
</div>
v<div class="all-devcies-section pad-t70 pad-b70">
    <div class="container">
        <div class="heading text-center">
            <h2>Buy pre-owned devices as good as new</h2>
            <p>No junk, more value</p>
        </div>
        <div class="three-devies-boxes owl-carousel owl-theme">
            @if(count($devicehome)>0)
            @foreach($devicehome as $devicess)
            <div class="item devies-box-col">
                @if($devicess['device_name'] != 'Others')
                <a href="{{ asset('/models/'.$devicess['device_name'])}}">
                    @else
                    <a href="{{ asset('/product-others')}}">
                        @endif
                        <div class="white-shad-box devies-box text-center"> <i><img src="{{ asset(Storage::url($devicess['image'])) }}" alt=""></i>
                            <p>{{ $devicess['device_name'] }}</p>
                        </div>
                    </a>
            </div>
            @endforeach
            @endif

        </div>
    </div>
</div>
<div class="search-filer-block search-mrg">
    <div class="container">
        <div class="search-bar">
            {{ Form::model('', ['url' => route('search-productnew') , 'method' => 'get']) }}

            <div class="row search-row search-filter justify-content-between">




                <div class="col-md-4 search-colum">
                    <div class="search-col">
                        <label>Search by Device</label>
                        <select class="form-control" name="device_name" onchange="getModelDevice(this)" required>
                            <option value="">Search By Device</option>
                            @foreach($device as $devicetype)
                            <option value="{{ $devicetype->device_name }}">{{ $devicetype->device_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <img src="{{ asset('img/ajax-loader.gif') }} " alt="" class="showloaderimg" style="display:none;">
                </div>



                <div class="col-md-4 search-colum">

                    <div class="search-col">
                        <label>Search by Model</label>
                        <select class="form-control showmodels" name="model_id" disabled=true required>
                            <option>Search By Model</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-md-4 search-colum">
                    <div class="row search-row">
                        <div class="col-sm-6 col-6 search-colum">
                            <div class="search-col">
                                <label>Min Price</label>
                                <input type="text" placeholder="Min Price $" class="form-control" name="min-price" id="minval">
                                <span id="errmsg"></span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-6 search-colum">
                            <div class="search-col">
                                <label>Max Price</label>
                                <input type="text" placeholder="Max Price $" class="form-control" name="max-price" id="maxval">
                                <span id="errmsg1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="search-filter-btn">
                    <button type="submit" class="btn blue-btn">SEARCH</button>
                </div>

            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<div class="addon-block ">
    <div class="container">
        <div class="d-flex justify-content-between addon-block-area ">
            <div class="addon-strip">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="addon-group people-powered"> <i><img src="{{ asset('img/icon1.png') }}" alt=""></i>
                            <div class="addon-info"><span>People Powered</span>
                                <p>{{ config('get.people-powered') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="addon-group no-junk"> <i><img src="{{ asset('img/icon2.png') }}" alt=""></i>
                            <div class="addon-info"><span>No Junk</span>
                                <p>{{ config('get.no-junk') }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 pad0">
                        <div class="addon-group happy-customer"> <i><img src="{{ asset('img/icon3.png') }}" alt=""></i>
                            <div class="addon-info"><span>100% Happy Customer</span>
                                <p>{{ config('get.happy-customer') }} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sell-product-btn">
                <?php
                if (!empty($logInedUser)) {

                    if ($logInedUser->role_id == 1) {
                        ?>
                        <a href="{{ url('/addProduct')}}">Sell Your Device</a></div>
    <?php } else { ?>

                    <a href="{{ url('/myInterest')}}">Buy a Product</a></div>
            <?php }
        } else {
            ?>
            <a href="{{ asset('/login')}}">Sell Your Device</a></div>
    <?php } ?>
</div>
</div>
</div>
<div class="broken-box">
    <div class="container">
        <div class="broken-box-inst">
            <a href="http://www.sellmybrokenphone.com.au/" target="_blank">Have A Broken Phone? Get Paid For It Now!</a>
        </div>
    </div>
</div>

<div class="our-product-section home-product bg-grey pad-t70 pad-b50">
    <div class="container">
        <div class="heading  text-center">
            <h2>Featured <span>Listings</span></h2>
        </div>
        <div class="product-content text-center">
            <p>{{ config('get.latest-product-text') }}</p>
        </div>
        <div class="product-listing ">





            <div class="product-show-slider">
                <div class="owl-carousel-product owl-theme">

                    @foreach($products as $product)

                    <div class="listing-product-col">
                        <div class="listing-box">
                            <span class="featured-icon-block">Featured</span>
                            <div class="listing-phone-box">
                                <?php
                                if (!empty($product->mainphoto)) {

                                    $i = 1
                                    ?>

                                    <a href="javascript:void(0)"><img src="{{ asset(Storage::url($product->mainphoto)) }}" alt=""></a>

<?php } else { ?>
                                    <a href="javascript:void(0)"><img src="{{ asset('img/NoPhone_grande.png') }}" alt=""></a>

<?php } ?>
                            </div>
                            <div class="view-detail-btn"><a href="{{ url('product/'.$product->product_slug)}}" class="blue-btn btn">VIEW DETAILS</a></div>
                            <div class="product-details text-center">
                                <div class="star-rating ">
                                    <input id="input-2" name="star_ratting" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $product->star_ratting }}" data-size="xs" disabled="">
                                </div>
                                <h2>{{ $product->item_title }}</h2>
                                <p>{{ substr($product->item_description, 0, 45) . '...' }}</p>
                                <div class="product-price"><span>$</span>{{ $product->final_price }}</div>
                            </div>
                        </div>
                    </div>



                    @endforeach

                </div>
            </div>




        </div>
    </div>
</div>
<div class="banner-section pad-t70 pad-b50">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="d-flex ads-banner-block ">
                    <div class="ads-banner">
                        <div class="heading">
                            <h2>Sell Your
                                Device</h2>
                        </div>
                        <p>Lorem ipsum dolor sit amet, conse
                            ctetur adipiscing elit.</p>
                        <div class="selling-now-btn">
                            @if(empty($login))
                            <a href="{{ asset('/login')}}" class="white-btn btn">Start Selling Now</a>
                            @else
                            <a href="{{ asset('/dashboard')}}" class="white-btn btn">Start Selling Now</a>
                            @endif

                        </div>
                    </div>
                    <div class="ads-product"><img src="{{ asset('img/ads-banner-phone.jpg') }}" alt=""></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="trust-pilot-block "><img src="{{ asset('img/trust-pilot.jpg') }}" alt=""></div>
            </div>
        </div>
    </div>
</div>
<div class="chooseus-section pad-t50 pad-b50">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6"><img src="{{ asset('img/choose.png') }}" alt=""></div>
            <div class="col-md-6">
                <div class="heading">
                    <h2>Why Choose <span>Us</span></h2>
                </div>
                <p> {{ config('get.why-choose-us-text') }} </p>
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

<script>
    $(document).ready(function () {
        //called when key is pressed in textbox
        $("#minval").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message

                $("#errmsg").html("Allow only numeric value").show();
                $('#errmsg').delay(2000).fadeOut();
                return false;
            } else if ($(this).val() > 500) {

                $("#errmsg").html("Amount should be less than $5000").show();
                $('#errmsg').delay(2000).fadeOut();
                return false;
            }
        });

        $("#maxval").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message



                return false;
            } else if ($(this).val() > 500) {

                $("#errmsg1").html("Amount should be less than $5000").show();
                //$('#errmsg1').delay(2000).fadeOut();
                return false;
            }
        });

    });

    function getModelDevice(id) {

        var selectedval = id.value;
        $(".showloaderimg").show();


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url('selectmodelforfilter')}}' + '/' + selectedval,
            type: 'GET',
            dataType: 'html',
            data: {

                "id": selectedval // method and token not needed in data
            },
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {

            },

            success: function (json) {

                $('.showmodels').attr('disabled', false);
                $(".showloaderimg").hide();
                $(".showmodels").html(json);

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });



    }


</script>

@include('includes.footer')
@endsection







