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
          @if ((Auth::guard('user')->check()))
            <li class="nav-item mbl-nav"><a class="nav-link" href="{{(Auth::guard('user')->user()->user_type == 'Buyer') ? route('frontend.user.userProfile') : route('frontend.supplier.supplierProfile')}}">My Profile</a></li>
            <li class="nav-item mbl-nav"><a class="nav-link" href="{{route('frontend.auth.logout')}}">Logout</a></li>
          @else
            <li class="nav-item mbl-nav"><a class="nav-link" href="route('frontend.auth.login')">Login</a></li>
            <li class="nav-item mbl-nav"><a class="nav-link" href="{{route('frontend.auth.register')}}">Register</a></li>
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
      @if ((Auth::guard('user')->check()))
        <a class="lgn-btn position-relative" href="{{(Auth::guard('user')->user()->user_type == 'Buyer') ? route('frontend.user.userProfile') : route('frontend.supplier.supplierProfile')}}">My Profile<span class="hide-msg-span count-msg supplier-unread-msg-count unread-buyer-count"></span></a>
        <a class="lgn-btn" href="{{route('frontend.auth.logout')}}"><i class="fas fa-sign-out-alt"></i> Logout</a>
      @else
        <a class="lgn-btn" href="route('frontend.auth.login')">Login</a> /
        <a class="lgn-btn" href="{{route('frontend.auth.register')}}"><i class="fas fa-sign-out-alt"></i>Register</a>
      @endif
    </div>
  </div>
</header>