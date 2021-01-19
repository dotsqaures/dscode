@php
use Illuminate\Support\Facades\Auth;
$settings = settings();
@endphp
<header class="header">
  <div class="container">
    <nav class="navbar navbar-expand-md navbar-light">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <i class="fas fa-bars"></i></button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
          @if (!(Auth::guard('user')->check()) || (Auth::guard('user')->check() && Auth::guard('user')->user()->user_type == 'Buyer'))
            <li class="nav-item"><a class="nav-link" href="{{(!Auth::guard('user')->check()) ? route('frontend.auth.login') : route('frontend.user.postings.create')}}">Make a Posting</a></li>
          @endif
          <li class="nav-item"><a class="nav-link" href="{{route('frontend.listing')}}">Browse Postings</a></li>
          @if (!(Auth::guard('user')->check()))
          <li class="nav-item mbl-nav">{{ link_to_route('frontend.auth.login', trans('Login'), [], ['class' => 'nav-link']) }}</li>
          @else
          <li class="nav-item mbl-nav">{{ link_to_route('frontend.auth.logout', trans('Logout'), [], ['class' => 'nav-link']) }}</li>
          @endif
          @if (!(Auth::guard('user')->check()))
            @if (config('access.users.registration'))
            <li class="nav-item mbl-nav">{{ link_to_route('frontend.auth.register', 'Register', [], ['class' => 'nav-link']) }}</li>
            @endif
          @else
            @if(Auth::guard('user')->user()->user_type == 'Buyer')
              <li class="nav-item mbl-nav">{{ link_to_route('frontend.user.userProfile', 'Profile', [], ['class' => 'nav-link']) }}</li>
            @else
              <li class="nav-item mbl-nav">{{ link_to_route('frontend.supplier.supplierProfile', 'Profile', [], ['class' => 'nav-link']) }}</li>
            @endif
          @endif
        </ul>
      </div>
    </nav>
    @if($settings->logo)
      <a class="logo" href="{{route('frontend.index')}}"><img src="{{route('frontend.index')}}/settings/logo/{{$settings->logo}}" alt=""></a>
    @else
      <a class="logo" href="{{route('frontend.index')}}"><img src="images/logo.png" alt=""></a>
    @endif
    <div class="rt-btn"> 
    @if (!(Auth::guard('user')->check()))
    {{ link_to_route('frontend.auth.login', trans('Login'), [], ['class' => 'get-start-btn']) }}
    @endif
    @if (!(Auth::guard('user')->check()))
      @if (config('access.users.registration'))
        {{ link_to_route('frontend.auth.register', 'Register', [], ['class' => 'get-start-btn']) }}
      @endif
    @else
      @if(Auth::guard('user')->user()->user_type == 'Buyer')
        {{ link_to_route('frontend.user.userProfile', 'Profile', [], ['class' => 'get-start-btn']) }}
      @else
        {{ link_to_route('frontend.supplier.supplierProfile', 'Profile', [], ['class' => 'get-start-btn']) }}
      @endif
    @endif
    @if ((Auth::guard('user')->check()))
      {{ link_to_route('frontend.auth.logout', trans('Logout'), [], ['class' => 'get-start-btn']) }}
    @endif
    </div>
  </div>
</header>