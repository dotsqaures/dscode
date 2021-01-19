@php

    use Illuminate\Support\Facades\Auth;
    $footermenu = \App\Helpers\BasicHelpers::FooterMenuNav();
@endphp


<footer class="footer ">
        <div class="footer-inner pad-t70 pad-b70">
          <div class="container">
            <div class=" d-flex justify-content-between footer-block">
              <div class="about-company footer-col">
                <div class="heading">
                  <h2>About Our Company</h2>
                </div>
                <div class="footer-logo">
                        <a href="{{ asset('/')}}">
                            <img src="{{ asset('storage/settings/' . config('get.MAIN_LOGO')) }} " alt="">
                            </a>

                </div>
                <p>{{ config('get.footer-text') }}</p>
              </div>
              <div class="explore-website footer-col">
                <div class="heading">
                  <h2>Explore Website</h2>
                </div>
                <ul>
                        @foreach($footermenu as $footeitem)
                  <li><a href="{{ asset('/pages/'.$footeitem->slug)}}">{{ $footeitem->title }}</a></li>
                  @endforeach

                  <li><a href="{{ asset('/pages/contact-us')}}">Contact Us</a></li>
                </ul>


                <div class="social_links">
                        <a href="https://www.facebook.com/" class="social" target="_blank"><i class="fab fa-facebook-square"></i></a>
                        <a href="https://twitter.com/" class="social" target="_blank"><i class="fab fa-twitter-square"></i></a>
                        <a href="https://www.instagram.com/" class="social" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/" class="social" target="_blank"><i class="fab fa-youtube-square"></i></a>
                        <a href="https://in.pinterest.com/" class="social" target="_blank"><i class="fab fa-pinterest-square"></i></a>
                        <a href="https://in.linkedin.com/" class="social" target="_blank"><i class="fab fa-linkedin"></i></a>
                    </div>

              </div>
              <div class="contact-us footer-col">
                <div class="heading">
                  <h2>Contact us</h2>
                </div>
                <div class="address"><i class="fas fa-map-marker-alt"></i><span>{{ config('get.ADDRESS') }}</span></div>
                <div class="mail"><i class="fas fa-envelope"></i><span><a href="{{ config('get.ADMIN_EMAIL') }}">{{ config('get.ADMIN_EMAIL') }}</a></span></div>
                <div class="phonenumber"> <i class="fas fa-mobile-alt"></i><span>
                  <a href="tel:{{ config('get.TELEPHONE') }}">{{ config('get.TELEPHONE') }}</a></span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="copyright-block">
          <div class="container">
            <p><a style="color:#fff;"  href="{{ asset('/pages/term-of-use')}}">{{ config('get.copyrighttext') }}</a></p>
          </div>
        </div>
      </footer>

    </div>
    <a href="#0" class="cd-top">Top</a>


