@php
    use Illuminate\Support\Facades\Route;
    $login = Auth::user();

    $menu = \App\Helpers\BasicHelpers::HeaderMenuNav();
    $menuother = \App\Helpers\BasicHelpers::HeaderMenuNavothers();

@endphp



<!DOCTYPE html>

<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet">

        <link rel="shortcut icon" href="{{ asset('img/Favicon Logo.png') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'SellBuyDevice')</title>

        <!-- Meta -->
        <meta name="description" content="@yield('meta_description', 'SellBuyDevice')">
        <meta name="author" content="@yield('meta_author', 'SellBuyDevice')">
        @yield('meta')




        <!-- Styles -->



            {{ Html::style('css/all.css') }}
            {{ Html::style('css/bootstrap.min.css') }}

            {{ Html::style('css/owl.carousel.min.css') }}
            {{ Html::style('css/owl.theme.default.min.css') }}
            {{ Html::style('css/style.css') }}
{{ Html::style('css/developer.css') }}
            {{ Html::style('css/responsive.css') }}






        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>

    </head>
    <body class="inside-page">

            <div class="outer">
                    <header class="header">
                      <div class="container">
                        <div class="d-flex justify-content-between align-items-center header-inner">
                          <div class="logo">
                              <a href="{{ asset('/')}}">
                              <img src="{{ asset('storage/settings/' . config('get.MAIN_LOGO')) }} " alt="">
                              </a>
                            </div>
                          <div class="top-header-right align-items-center d-flex">
                            <div class="top-search-bar ">
                                    {{ Form::model('', ['url' => route('searchresult') , 'method' => 'get']) }}
                                    <input name="productname" type="text" placeholder="Search for device model..." class="form-control">
                                    <!--<button type="submit" class="search-btn"><i class="fas fa-search"></i></button>-->
                                    <button type="" class="search-btn"><i class="fas fa-search"></i></button>
                                    {{ Form::close() }}
                                </div>
                            <div class="top-btn">
                                @if(empty($login))
                                <a href="{{ asset('/login')}}">Login</a>
                                <a href="{{ asset('/register')}}">Register</a>
                                @else
                                <a href="{{ asset('/logout')}}">logout</a>
                                <a href="{{ asset('/profile')}}">My Profile</a>
                                @endif

                            </div>
                            @if(empty($login))
                            <div class="add-cart-beg">
                                <a href="{{ url('/cart') }}">
                                    <?php
                                   $checksession = Session::has('cart');

                                   if($checksession)
                                   {
                                       $getval = Session::get('cart');

                                       if(!empty($getval)){
                                       $showcountarray = count(array_unique($getval)); ?>

                                       <span class="product-count">{{ $showcountarray }}</span>



                                <?php } } ?>
                                <i class="fas fa-shopping-cart"></i> </a>
                            </div>
                            @else
                            <div class="add-cart-beg">
                                    <a href="{{ url('/cart') }}">

                                        <?php
                                      $cartitem  =   \App\Helpers\BasicHelpers::getCartItemTotal();
                                        ?>

                                        @if($cartitem > 0)
                                        <span class="product-count">{{ $cartitem }}</span>
                                        @else

                                        @endif

                                <i class="fas fa-shopping-cart"></i> </a>
                                </div>
                            @endif

                          </div>
                        </div>
                        <nav class="top-menu ">
                            <div class="body-overlay"></div>
                            <a href="javascript:void(0)" class="menuImage nav-icon"> <span></span> <span></span> <span></span> </a>
                            <div class="menu iphonNav " >
                              <ul class="d-flex justify-content-between top-menu-inner">
                                    @foreach($menu as $menuitem)

                                    <li ><a href="{{ asset('/models/'.$menuitem->slug) }} ">
                                      <p>{{ $menuitem->device_name }}</p>
                                      </a>
                                      @if($menuitem->slug != 'iPhones')

                                    @php
                                    $brandlist = \App\Helpers\BasicHelpers::GetBrandMenuNav($menuitem->id);
                                    @endphp
                                    @if(count($brandlist)>0)
                                    <ul class="dropdown-menu">
                                    @foreach($brandlist as $val)
                                    <li><a href="{{ asset('/brand/'.$val->slug) }}">{{ $val->title }}</a></li>
                                    @endforeach
                                    </ul>
                                    @endif

                                 @else

                                    @php
                                    $modeldetail = \App\Helpers\BasicHelpers::SubMenuNav($menuitem->id);
                                    @endphp
                                    @if(count($modeldetail)>0)
                                    <ul class="dropdown-menu">
                                    @foreach($modeldetail as $val)
                                    <li><a href="{{ asset('/search/'.$val->model_slug) }}">{{ $val->model_name }}</a></li>
                                    @endforeach
                                    </ul>
                                    @endif


                                 @endif


                                    </li>

                                      @endforeach

                                <li><a href="{{ asset('/product-others')}}"><i class="fas fa-certificate"></i>
                                  <p>Others</p>
                                  </a>

                                <ul>
                                        @foreach($menuother as $other)
                                <li><a href="{{ asset('/models/'.$other->device_name) }}"> {{ $other->device_name }}</a>
                                    @php
                                  $modeldetail = \App\Helpers\BasicHelpers::SubMenuNav($other->id);

                                 @endphp


                                 @if(count($modeldetail)>0)
                                 <ul class="dropdown-menu">
                                 @foreach($modeldetail as $val)

                                  <li><a href="{{ asset('/models/'.$val->model_slug) }}">{{ $val->model_name }}</a></li>

                                  @endforeach
                                </ul>
                                 @endif


                                </li>
                                @endforeach

                                </ul>

                                  </li>
                              </ul>
                            </div>
                          </nav>
                      </div>
                    </header>


            @yield('content')





            {{ Html::script('js/jquery-3.3.1.min.js') }}
            {{ Html::script('js/mb-slider.js') }}
            {{ Html::script('js/popper.min.js') }}
            {{ Html::script('js/bootstrap.min.js') }}
            {{ Html::script('js/iphone-menu.js') }}
            {{ Html::script('js/owl.carousel.js') }}
            {{ Html::script('js/custom.js') }}
            {{ Html::script('js/bottom-top.js') }}
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

            {{ Html::script('js/jquery.flexslider.js') }}

            {{ Html::script('js/jquery.fancybox.pack.js') }}
            {{ Html::style('css/jquery.fancybox.css') }}




    </body>
</html>
