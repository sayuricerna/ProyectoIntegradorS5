@extends('layouts.app')
@section('content')
<style>
/* .brand-list li , .category-list li {
line-height: 40px;
}
.brand-list li, .category-list li, .chk-category, .chk-brand {
width: 1rem;
height: 1rem;
color: #e4e4e4;
border: 0.125rem solid currentColor;
border-radius: 0;
margin-right: 0.75rem;
} */
.filled-heart {
color: #ff9900ff;
}
</style>
<main class="pt-90">
  <section class="shop-main container d-flex pt-4 pt-xl-5">
    <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
      <div class="aside-header d-flex d-lg-none align-items-center">
        <h3 class="text-uppercase fs-6 mb-0">Filtar por</h3>
        <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
      </div>
      <div class="pt-4 pt-lg-0"></div>
        <div class="accordion" id="categories-list">
          <div class="accordion-item mb-4 pb-3">
          <h5 class="accordion-header" id="accordion-heading-1">
            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1">
              Categorías
              <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                <path d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" /> </g>
              </svg>
            </button>
          </h5>
          <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
          aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
            <div class="accordion-body px-0 pb-0 pt-3 category-list">
              <ul class="list list-inline mb-0">
                @foreach ($categories as $category)
                <li class="list-item">
                  <span class="menu-link py-1">
                    <input type="checkbox" class="chk-category" name="categories" value="{{ $category->id }}"
                    @if (in_array($category->id, explode(',', $f_categories))) checked='checked'  @endif>
                    {{ $category->name }}
                  </span>
                  <span class="text-right float-end">{{$category->products->count()}}</span>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="accordion" id="brand-filters">
        <div class="accordion-item mb-4 pb-3">
          <h5 class="accordion-header" id="accordion-heading-brand">
            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
              data-bs-target="#accordion-filter-brand" aria-expanded="true" aria-controls="accordion-filter-brand">
              Marcas
              <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                  <path
                  d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                </g>
              </svg>
            </button>
          </h5>
          <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
            aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
            <div class="search-field multi-select accordion-body px-0 pb-0">
              <ul class="list list-inline mb-0 brand-list">
              @foreach ($brands as $brand)
                <li class="list-item">
                  <span class="menu-link py-1">
                    <input type="checkbox" name="brands" value="{{ $brand->id }}" class="chk-brand" 
                    @if (in_array($brand->id, explode(',', $f_brands))) checked='checked' @endif>
                      {{ $brand->name }}
                  </span>
                  <span class="text-right float-end">
                    {{ $brand->products->count() }}
                  </span>
                </li>
              @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="shop-list flex-grow-1">
      <div class="mb-3 pb-2 pb-xl-3"></div>
      <div class="d-flex justify-content-between mb-4 pb-md-2">
        <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
          <a href="{{ route('home.index') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
          <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
          <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Tienda</a>
        </div>
        <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1" >
          <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Page Size" id="pagesize" style="margin-right: 20px;"
          name="pagesize">
            <option value="12"{{$size==12 ? 'selected':''}}>Mostrar</option>
            <option value="24"{{$size==24 ? 'selected':''}}>24</option>
            <option value="48"{{$size==48 ? 'selected':''}}>48</option>
            <option value="102"{{$size==102 ? 'selected':''}}>102</option>
          </select>
          <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Short Items" name='orderby' id="orderby" >
            <option value="-1"{{$order==-1 ? 'selected':''}}>Por defecto</option>
            <option value="1"{{$order==1 ? 'selected':''}}>Precio: Bajo - alto</option>
            <option value="2"{{$order==2 ? 'selected':''}}>Precio: Alto - bajo</option>
          </select>
          <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>
          <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
            <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside" data-aside="shopFilter">
              <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10" fill="none"
              xmlns="http://www.w3.org/2000/svg">
                href="#icon_filter" />
              </svg>
              <span class="text-uppercase fw-medium d-inline-block align-middle">Filtro</span>
            </button>
          </div>
        </div>
      </div>
      <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
        @foreach ( $products as $product)
        <div class="product-card-wrapper">
          <div class="product-card mb-3 mb-md-4 mb-xxl-5">
            <div class="pc__img-wrapper">
              <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <a href=" {{ route('shop.product.details',['product_slug'=>$product->slug]) }}"><img loading="lazy" src="{{ asset('uploads/products') }}/{{ $product->image }}" width="330"
                    height="400" alt=" {{ $product->name }}" class="pc__img"></a>
                  </div>
                  <div class="swiper-slide">
                    @foreach ( explode(",",$product->images) as $gimg )
                    <a href=" {{ route('shop.product.details',['product_slug'=>$product->slug]) }}"><img loading="lazy" src="{{ asset('uploads/products') }}/{{ $product->image }}"
                    width="330" height="400" alt="{{ $product->name }}" class="pc__img"></a>                            
                    @endforeach
                  </div>
                </div>
                <span class="pc__img-prev">
                  <svg width="7" height="11" viewBox="0 0 7 11"  xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_prev_sm"/>
                  </svg>
                </span>
                <span class="pc__img-next">
                  <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_next_sm" />
                  </svg>
                </span>
              </div>
              @if ($product->variants->count() > 1)
                <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}"
                class="pc__atc anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                data-aside="cartDrawer" title="View Options">
                Ver Opciones
                </a>
              @else
                @php
                  $variant = $product->variants->first();
                @endphp
                @php
                  $isInCart = false;
                  foreach(Cart::instance('cart')->content() as $item) {
                    if ($item->options->variant_id == $variant->id) {
                      $isInCart = true;
                      break;
                    }
                  }
                @endphp
                @if ($variant && $variant->quantity > 0)
                  @if ($isInCart)
                    <a href="{{ route('cart.index') }}"
                    class="pc__atc anim_appear-bottom position-absolute border-0 text-uppercase fw-medium btn btn-warning mb-3">
                    Ir al carrito
                    </a>
                  @else
                    <form name="addtocart-form" method="POST" action="{{ route('cart.add') }}">
                      @csrf
                      <input type="hidden" name="id" value="{{ $product->id }}" />
                      <input type="hidden" name="quantity" value="1" />
                      <input type="hidden" name="name" value="{{ $product->name }}" />
                      <input type="hidden" name="price" value="{{ $variant->sale_price ?? $variant->regular_price }}" />
                      <input type="hidden" name="variant_id" value="{{ $variant->id }}" /> {{-- AQUI EL CAMPO CRUCIAL --}}
                      <button type="submit"
                        class="pc__atc anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                        data-aside="cartDrawer" title="Add To Cart">
                        Añadir al carrito
                      </button>
                    </form>
                  @endif
                @else
                  <button class="pc__atc anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium" disabled>
                  Agotado
                  </button>
                @endif
              @endif
            </div>
            <div class="pc__info position-relative">
              <p class="pc__category">{{ $product->category->name }}</p>
              <h6 class="pc__title"><a href=" {{ route('shop.product.details',['product_slug'=>$product->slug]) }}">{{$product->name}}</a></h6>
              <div class="product-card__price d-flex">
                @php
                  $isVariantProduct = $product->variants->count() > 1;
                  $onSaleVariants = $product->variants->where('on_sale', true);
                  $showSalePrice = false;
                  if ($onSaleVariants->isNotEmpty()) {
                    $showSalePrice = true;
                  }
                @endphp
                @if($isVariantProduct)
                  @if($showSalePrice)
                    @php
                      $minSalePrice = $onSaleVariants->min('sale_price');
                      $maxSalePrice = $onSaleVariants->max('sale_price');
                      $minRegularPrice = $product->variants->min('regular_price');
                      $maxRegularPrice = $product->variants->max('regular_price');
                    @endphp
                    <span class="new-price">${{ number_format($minSalePrice, 2) }} - ${{ number_format($maxSalePrice, 2) }}</span>
                      <span class="old-price" style="text-decoration: line-through; color: #999;">
                      ${{ number_format($minRegularPrice, 2) }} - ${{ number_format($maxRegularPrice, 2) }}
                    </span>
                  @else
                    @php
                    $minPrice = $product->variants->min('regular_price');
                    $maxPrice = $product->variants->max('regular_price');
                    @endphp
                    <span class="price">${{ number_format($minPrice, 2) }} - ${{ number_format($maxPrice, 2) }}</span>
                  @endif
                @else
                  @php
                    $firstVariant = $product->variants->first();
                  @endphp
                  @if($firstVariant && $firstVariant->on_sale)
                    <span class="new-price">${{ number_format($firstVariant->sale_price, 2) }}</span>
                    <span class="old-price" style="text-decoration: line-through; color: #999;">${{ number_format($firstVariant->regular_price, 2) }}</span>
                  @else
                    <span class="price">${{ number_format($firstVariant->regular_price, 2) }}</span>
                  @endif
                @endif
              </div>
            @if (Cart::instance('wishlist')->content()->where('id',$product->id)->count()>0)
              <form method="POST" action="{{ route('wishlist.item.remove',['rowId'=>Cart::instance('wishlist')->content()->where('id',$product->id)->first()->rowId]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist filled-heart" title="Añadir a la lista de deseos">
                  <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_heart" />
                  </svg>
                </button>
              </form>
            @else
              <form method="POST" action="{{ route('wishlist.add') }}" >
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}"/>
                <input type="hidden" name="name" value="{{ $product->name }}"/>
                <input type="hidden" name="price" value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price}}">
                <input type="hidden" name="quantity" value="1"/>
                <button type="submit" class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist" title="Añadir a la lista de deseos">
                  <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_heart" />
                  </svg>
                </button>
              </form>
            @endif
            </div>
          </div>
        </div>                
        @endforeach
      </div>
      <div class="divider">
        <div class="flec items-center justify-between flex-wrap gap10 wgp-pagination"> 
          {{ $products->withQueryString()->links('pagination::bootstrap-5')}}  
        </div>
      </div>
    </div>
  </section>
</main>

<form id="frmfilter" method="GET" action="{{ route('shop.index')}}">
  <input type="hidden" name="page" value="{{ $products->currentPage()}}">
  <input type="hidden" name="size" id='size' value="{{ $size}}">    
  <input type="hidden" name="order" id='order' value="{{ $order}}">    
  <input type="hidden" name="brands" id='hdnbrands'>
  <input type="hidden" name="categories" id='hdnCategories'>
</form>
@endsection
@push('scripts')
<script>
  $(function(){

    $('#pagesize').on('change',function(){
      $('#size').val($("#pagesize option:selected").val());
      $('#frmfilter').submit();
    });
    $('#orderby').on('change',function(){
      $('#order').val($("#orderby option:selected").val());
      $('#frmfilter').submit();
    });
    $("input[name='brands']").on('change',function(){
      var brands = "";
      $("input[name='brands']:checked").each(function(){
        if(brands == "")
        {
          brands += $(this).val();
        }
        else
        {
          brands += ","+$(this).val();
        }
      });
      $('#hdnbrands').val(brands);
      $('#frmfilter').submit();
    });
    $("input[name='categories']").on('change',function(){
      var categories = "";
      $("input[name='categories']:checked").each(function(){
        if(categories == "")
        {
          categories += $(this).val();
        }
        else
        {
          categories += ","+$(this).val();
        }
      });
      $('#hdnCategories').val(categories);
      $('#frmfilter').submit();
    });
  });
  </script>
@endpush
