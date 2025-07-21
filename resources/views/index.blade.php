@extends('layouts.app')
@section('content')
<main class="container">
  {{-- <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow" data-settings='{ "autoplay": {"delay": 5000}, "slidesPerView": 1, "effect": "fade", "loop": true }'>
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <div class="overflow-hidden position-relative h-100">
          <div class="slideshow-character position-absolute bottom-0 pos_right-center">
            <img loading="lazy" src="{{ asset('assets/images/headerImage.png') }}" width="542" height="733" class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
          </div>
          <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
            <h2 class="fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Tienda de ropa física y online</h2>
            <h2 class=" fw-bold animate animate_fade animate_btt animate_delay-5">Prendas oversize, boxyfit, Old money</h2>
            <a href="{{ route('shop.index') }}" class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Comprar Ahora</a>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5"> </div>
    </div>
  </section> --}}
  <section class=" js-swiper-slider swiper-number-pagination slideshow" data-settings='{ "autoplay": {"delay": 5000}, "slidesPerView": 1, "effect": "fade", "loop": true }'>
    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <div class="overflow-hidden position-relative h-100">
          <div class="slideshow-character position-absolute bottom-0 pos_right-center">
            <img loading="lazy" src="{{ asset('assets/images/headerImage.png') }}" width="542" height="733" class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
          </div>
          <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
            <h2 class="fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Tienda de ropa física y online</h2>
            <h2 class=" fw-bold animate animate_fade animate_btt animate_delay-5">Prendas oversize, boxyfit, Old money</h2>
            <a href="{{ route('shop.index') }}" class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Comprar Ahora</a>
          </div>
        </div>
      </div>
    </div>
  </section>
    {{-- CATEGORIAS --}}
  <div class="container mw-1620 bg-white border-radius-10">
    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    <section class="category-carousel container">
      <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4"> Categorías</h2>
      <div class="position-relative">
        <div class="swiper-container js-swiper-slider" data-settings='{  "autoplay": { "delay": 5000  }, "slidesPerView": 8,  "slidesPerGroup": 1,  "effect": "none",  "loop": true,  "navigation": { "nextEl": ".products-carousel__next-1", "prevEl": ".products-carousel__prev-1"  },   "breakpoints": {  "320": { "slidesPerView": 2,   "slidesPerGroup": 2,   "spaceBetween": 15   },  "768": { "slidesPerView": 4, "slidesPerGroup": 4, "spaceBetween": 30 },  "992": {  "slidesPerView": 6, "slidesPerGroup": 1,"spaceBetween": 45, "pagination": false },  "1200": {  "slidesPerView": 8, "slidesPerGroup": 1, "spaceBetween": 60, "pagination": false  }  } }'>
          <div class="swiper-wrapper">
            @foreach ($categories as $category) 
            <div class="swiper-slide">
              <img loading="lazy" class="w-100 h-auto mb-3" src="{{ asset('uploads/categories')}}/{{ $category->image }}" width="124"   height="124" alt="" />
              <div class="text-center">
                <a href="{{ route('shop.index',['categories'=>$category->id]) }}" class="menu-link fw-medium">{{ $category->name }}</a>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        <div class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
          <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_prev_md" />
          </svg>
        </div>
        <div  class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
          <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg>
        </div>
      </div>
    </section>

    {{-- ABOUT US --}}
    <section id="about">
      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
      <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Acerca de Nosotros</h2>
      <div class="container">  
        <div class="row align-items-center">
          <div class="col-lg-8 mb-4 mb-lg-0">
            <p class="lead">
              En <strong>Swinroom</strong> fusionamos lo mejor de lo urbano y lo elegante para crear un estilo único.<br>
              Somos una tienda de ropa física y online ubicada en Santo Domingo, Ecuador, especializada en prendas <em>oversize</em>, <em>boxyfit</em> y con un toque <em>old money</em>.<br>
              Nuestro objetivo es que expreses tu personalidad a través de cada prenda, combinando comodidad, tendencia y calidad. 🦄✨
            </p>
          </div>
          <div class="col-lg-4 text-center text-lg-start">
            <div class="mb-4">
              <a href="{{ route('home.index') }}">
                <img src="{{ asset('assets/images/logo.jpg')}}" class="img-fluid" style="max-height: 120px; width: auto;">
              </a>
            </div>     
            <div class="contact-info">
              <p class="mb-1"><i class="bi bi-geo-alt-fill me-2"></i>Santo Domingo, Ecuador📍</p>
              <p class="mb-1"><i class="bi bi-envelope-fill me-2"></i><strong>email@swinroom.com</strong></p>
              <ul class="social-links list-unstyled d-flex justify-content-center gap-3 mb-0">
                  <li>
                    <a href="https://maps.app.goo.gl/bSfnGQs8EkzSo8sn8" target="_blank" class="footer__social-link d-block">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                      </svg>
                    </a>
                  </li>   
                  <li>
                    <a href="https://www.instagram.com/swin.room/" class="footer__social-link d-block">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                      </svg>
                    </a>
                  </li>
                  <li>
                    <a href="https://wa.me/593995712907" target="_blank" class="footer__social-link d-block">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                      </svg>
                    </a>
                  </li> 

                  <li>
                    <a href="tel:+593995712907" class="footer__social-link d-block">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                      </svg>
                    </a>
                  </li>
                  <li>
                    <a href="https://www.tiktok.com/@swin.room" target="_blank" class="footer__social-link d-block">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
                        <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/>
                      </svg>
                    </a>
                  </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    {{-- PRODUCTOS DESTACADOS  --}}
    <section class="products-grid container">
    <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Productos destacados</h2>
    <div class="row">
      @foreach ($featured_products as $featured_product  )
      <div class="col-6 col-md-4 col-lg-3">
        <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
          <div class="pc__img-wrapper">
            <a href="{{ route('shop.product.details',['product_slug'=>$featured_product->slug]) }}">
              <img loading="lazy" src="{{ asset('uploads/products')}}/{{ $featured_product->image }}" width="330" height="400"
            alt="{{ $featured_product->name }}" class="pc__img">
            </a>
          </div>
          <div class="pc__info position-relative">
            <h6 class="pc__title"><a href="{{ route('shop.product.details',['product_slug'=>$featured_product->slug]) }}">{{ $featured_product->name }}</a></h6>
            <div class="product-card__price d-flex align-items-center">
              <span class="money price text-secondary">
                @if ($featured_product->sale_price)
                  <s>${{ $featured_product->regular_price}} </s> ${{ $featured_product->sale_price }}
                @else
                  ${{$featured_product->regular_price }}  
                @endif
              </span>
            </div>
          </div>
        </div>
      </div>
    @endforeach
    </div><!-- /.row -->
    <div class="text-center mt-2">
    <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="#">Cargar más</a>
    </div>
    </section>
  </div> 
</main>
@endsection