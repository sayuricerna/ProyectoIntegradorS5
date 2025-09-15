@extends('layouts.app')
@section('content')
<style>
  .filled-heart {
    color: #ff9900ff; 
  }
</style>
<main class="pt-90">
  <div class="mb-md-1 pb-md-3"></div>
  <section class="product-single container">
    <div class="row">
      <div class="col-lg-7">
        {{-- Galería de imágenes --}}
        <div class="product-single__media" data-media-type="vertical-thumbnail">
          <div class="product-single__image">
            <div class="swiper-container">
              <div class="swiper-wrapper">
                @php
                  $images = explode(',', $product->image);
                @endphp
                @foreach ($images as $gimg)
                <div class="swiper-slide product-single__image-item">
                  <img loading="lazy" class="h-auto" src="{{ asset('uploads/products') }}/{{ $gimg }}"
                    width="674" height="674" alt="" />
                  <a data-fancybox="gallery" href="{{ asset('uploads/products') }}/{{ $gimg }}" data-bs-toggle="tooltip"
                     data-bs-placement="left" title="Zoom">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <use href="#icon_zoom" />
                    </svg>
                  </a>
                </div>
                @endforeach
              </div>
              <div class="swiper-button-prev">
                <svg width="7" height="11" viewBox="0 0 7 11"><use href="#icon_prev_sm" /></svg>
              </div>
              <div class="swiper-button-next">
                <svg width="7" height="11" viewBox="0 0 7 11"><use href="#icon_next_sm" /></svg>
              </div>
            </div>
          </div>
          <div class="product-single__thumbnail">
            <div class="swiper-container">
              <div class="swiper-wrapper">
                @foreach ($images as $gimg)
                <div class="swiper-slide product-single__image-item">
                  <img loading="lazy" class="h-auto"
                    src="{{ asset('uploads/products/thumbnails') }}/{{ $gimg }}"
                    width="104" height="104" alt="" />
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- INFO PRODUCTO --}}
      <div class="col-lg-5">
        <div class="d-flex justify-content-between mb-4 pb-md-2">
          <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Tienda</a>
          </div>
        </div>
        <h1 class="product-single__name">{{ $product->name }}</h1>
        {{-- VARIANTES --}}
        @if ($product->variants->count() > 0)
          @php
              $colors = $product->variants->pluck('color')->filter()->unique()->values();
              $sizes = $product->variants->pluck('size')->filter()->unique()->values();
              $variants = $product->variants->toJson();
          @endphp
          {{-- Color --}}
          @if ($colors->isNotEmpty())
          <div class="product-single__options color-options">
            <h4 class="product-single__options-title">Color:</h4>
            <div class="product-single__options-list">
              @foreach ($colors as $color)
                <button type="button" class="btn btn-outline-dark btn-sm variant-option"
                  data-attribute="color" data-value="{{ $color }}">{{ $color }}</button>
              @endforeach
            </div>
          </div>
          @endif
          {{-- Talla --}}
          @if ($sizes->isNotEmpty())
          <div class="product-single__options size-options">
            <h4 class="product-single__options-title">Talla:</h4>
            <div class="product-single__options-list">
              @foreach ($sizes as $size)
                <button type="button" class="btn btn-outline-dark btn-sm variant-option"
                  data-attribute="size" data-value="{{ $size }}">{{ $size }}</button>
              @endforeach
            </div>
          </div>
          @endif
        @endif
        <div class="product-single__short-desc">
          <p>{{ $product->short_description }}</p>
        </div>
        {{-- PRECIO --}}
        <div class="product-single__price"></div>
        {{-- FORMULARIO AÑADIR AL CARRITO --}}
        <div id="add-to-cart-container">
          <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
            @csrf
            <div class="product-single__addtocart">
              <div class="qty-control position-relative">
                <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center">
                <div class="qty-control__reduce">-</div>
                <div class="qty-control__increase">+</div>
              </div>
              <input type="hidden" name="id" value="{{ $product->id }}"/>
              <input type="hidden" name="name" value="{{ $product->name }}"/>
              <input type="hidden" name="price" value=""/>
              <input type="hidden" name="variant_id" id="variant-id-input" value=""/> 
              <button type="submit" class="btn btn-primary btn-addtocart" data-aside="cartDrawer">Añadir al carrito</button>
            </div>
          </form>
          <a href="{{ route('cart.index') }}" id="go-to-cart-btn" class="btn btn-warning btn-go-to-cart d-none">Ir al carrito</a>
        </div>
        {{-- Wishlist --}}
        <div class="product-single__addtolinks">
          @if (Cart::instance('wishlist')->content()->where('id',$product->id)->count()>0)
          <form method="POST" action="{{ route('wishlist.item.remove',['rowId'=>Cart::instance('wishlist')->content()->where('id',$product->id)->first()->rowId]) }}" id="frm-remove-item">
              @csrf
              @method('DELETE')
              <a href="javascript::void(0)" class="menu-link menu-link_us-s add-to-wishlist filled-heart" onclick="document.getElementById('frm-remove-item').submit();" >
                <svg width="16" height="16" viewBox="0 0 20 20"><use href="#icon_heart" /></svg>
                <span>Quitar de lista de deseos</span>
              </a>
          </form>
          @else
          <form method="POST" action="{{ route('wishlist.add') }}" id="wishlist-form">
              @csrf
              <input type="hidden" name="id" value="{{ $product->id }}"/>
              <input type="hidden" name="name" value="{{ $product->name }}"/>
              <input type="hidden" name="price" value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price}}"/>
              <input type="hidden" name="quantity" value="1"/>
              <a href="javascript::void(0)" class="menu-link menu-link_us-s add-to-wishlist " onclick="document.getElementById('wishlist-form').submit()">
                <svg width="16" height="16" viewBox="0 0 20 20"><use href="#icon_heart" /></svg>
                <span>Añadir a lista de deseos</span>
              </a>
          </form>
          @endif
        </div>
        {{-- META INFO --}}
        <div class="product-single__meta-info">
          <div class="meta-item"><label>Referencia de almacén:</label><span>{{ $product->sku }}</span></div>
          <div class="meta-item"><label>Categoría:</label><span>{{ $product->category->name }}</span></div>
          <div class="meta-item"><label>Descripción:</label><span>{{ $product->short_description }}</span></div>
          <div class="meta-item"><label>Información adicional:</label><span>{{ $product->short_description }}</span></div>            
        </div>
      </div>
    </div>
  </section>
  {{-- RELACIONADOS (sin cambios) --}}
  <div class="mb-md-1 pb-md-3"></div>
    <div class="mb-md-1 pb-md-3"></div>
    <section class="products-carousel container">
      <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4"><strong>Otras prendas</strong></h2>
      <div id="related_products" class="position-relative">
        <div class="swiper-container js-swiper-slider" data-settings='{
            "autoplay": false,
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "effect": "none",
            "loop": true,
            "pagination": {
              "el": "#related_products .products-pagination",
              "type": "bullets",
              "clickable": true
            },
            "navigation": {
              "nextEl": "#related_products .products-carousel__next",
              "prevEl": "#related_products .products-carousel__prev"
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 3,
                "slidesPerGroup": 3,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "spaceBetween": 30
              }
            }
          }'>
          <div class="swiper-wrapper">
            @foreach ($products as $rproduct)
            <div class="swiper-slide product-card">
 <div class="pc__img-wrapper">
  <a href="{{ route('shop.product.details',['product_slug'=>$rproduct->slug]) }}" class="pc__img-link">
    <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $rproduct->image }}" width="330" height="400" alt="{{ $rproduct->name }}" class="pc__img">
    @php
      $secondaryImage = collect(explode(',', $rproduct->images))->first();
    @endphp
    @if($secondaryImage)
      <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $secondaryImage }}" width="330" height="400" alt="{{ $rproduct->name }}" class="pc__img pc__img-second">
    @endif
  </a>
  {{-- Lógica para mostrar los botones --}}
  @if (Cart::instance('cart')->content()->where('id', $rproduct->id)->count() > 0)
    {{-- Si el producto (único o variante) ya está en el carrito --}}
    <a href="{{ route('cart.index') }}" class="pc__atc anim_appear-bottom position-absolute border-0 text-uppercase fw-medium btn btn-warning mb-3">Ir al carrito</a>
  @else
    {{-- Si el producto no está en el carrito, revisamos si tiene variantes --}}
    @if ($rproduct->variants->count() > 1)
      {{-- Si tiene más de una variante, mostramos "Ver Opciones" --}}
      <a href="{{ route('shop.product.details', ['product_slug' => $rproduct->slug]) }}" class="pc__atc anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium">Ver Opciones</a>
    @else
      {{-- Si no tiene variantes o solo tiene una (producto único), mostramos "Añadir al carrito" --}}
      <form name="addtocart-form" method="POST" action="{{ route('cart.add') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $rproduct->id }}"/>
        <input type="hidden" name="quantity" value="1"/>
        <input type="hidden" name="name" value="{{ $rproduct->name }}"/>
        <input type="hidden" name="price" value="{{ $rproduct->sale_price == '' ? $rproduct->regular_price : $rproduct->sale_price}}"/>
        <input type="hidden" name="variant_id" value="{{ $rproduct->variants->first()->id }}"/>
        <button type="submit" class="pc__atc anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-add-cart js-open-aside" data-aside="cartDrawer" title="Add To Cart"> Añadir al carrito</button>
      </form>
    @endif
  @endif
</div>
              <div class="pc__info position-relative">
                <p class="pc__category">{{ $rproduct->category->name }}</p>
                <h6 class="pc__title"><a href="{{ route('shop.product.details',['product_slug'=>$product->slug]) }}">{{$rproduct->name}}</a></h6>
                {{-- <div class="product-card__price d-flex">
                  <span class="money price">
                    @if($rproduct->on_sale && $rproduct->sale_price > 0)
                      <span class="new-price">${{ $rproduct->sale_price }}</span>
                      <span class="old-price" style="text-decoration: line-through; color: #999;">${{ $rproduct->regular_price }}</span>
                    @else
                      <span class="price">${{ $rproduct->regular_price }}</span>
                    @endif
                  </span>
                </div> --}}
              <div class="product-card__price d-flex">
                  @php
                      $firstVariant = $rproduct->variants->first();
                      $isVariantProduct = $rproduct->variants->count() > 1;
                      if ($isVariantProduct) {
                          $onSaleVariants = $rproduct->variants->where('on_sale', true);
                          $showSalePrice = $onSaleVariants->isNotEmpty();
                      } else {
                          $showSalePrice = $firstVariant && $firstVariant->on_sale;
                      }
                  @endphp
                  @if($showSalePrice)
                      @php
                          $minSalePrice = $isVariantProduct ? $onSaleVariants->min('sale_price') : $firstVariant->sale_price;
                          $maxSalePrice = $isVariantProduct ? $onSaleVariants->max('sale_price') : $firstVariant->sale_price;
                          $minRegularPrice = $isVariantProduct ? $rproduct->variants->min('regular_price') : $firstVariant->regular_price;
                          $maxRegularPrice = $isVariantProduct ? $rproduct->variants->max('regular_price') : $firstVariant->regular_price;
                      @endphp
                      <span class="new-price">${{ number_format($minSalePrice, 2) }} @if($isVariantProduct) - ${{ number_format($maxSalePrice, 2) }} @endif</span>
                      <span class="old-price" style="text-decoration: line-through; color: #999;">
                          ${{ number_format($minRegularPrice, 2) }} @if($isVariantProduct) - ${{ number_format($maxRegularPrice, 2) }} @endif
                      </span>
                  @else
                      @php
                          $minPrice = $isVariantProduct ? $rproduct->variants->min('regular_price') : $firstVariant->regular_price;
                          $maxPrice = $isVariantProduct ? $rproduct->variants->max('regular_price') : $firstVariant->regular_price;
                      @endphp
                      <span class="price">${{ number_format($minPrice, 2) }} @if($isVariantProduct) - ${{ number_format($maxPrice, 2) }} @endif</span>
                  @endif
              </div>
                <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                  title="Add To Wishlist">
                  <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_heart" />
                  </svg>
                </button>
              </div>
            </div>
          @endforeach
          </div><!-- /.swiper-wrapper -->
        </div><!-- /.swiper-container js-swiper-slider -->
        <div class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
          <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_prev_md" />
          </svg>
        </div><!-- /.products-carousel__prev -->
        <div class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
          <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_md" />
          </svg>
        </div><!-- /.products-carousel__next -->
        <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
        <!-- /.products-pagination -->
      </div><!-- /.position-relative -->
    </section>
</main>
@endsection
@push('scripts')
<script>
    const variants = @json($product->variants);
    const cartItems = @json(Cart::instance('cart')->content());
    let selectedOptions = {};
    let selectedVariant = null;
    document.addEventListener('DOMContentLoaded', () => {
        const optionButtons = document.querySelectorAll('.variant-option');
        const priceElement = document.querySelector('.product-single__price');
        const variantIdInput = document.getElementById('variant-id-input');
        optionButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const attribute = e.target.dataset.attribute;
                const value = e.target.dataset.value;
                document.querySelectorAll(`button[data-attribute="${attribute}"]`).forEach(btn => {
                    btn.classList.remove('active');
                });
                e.target.classList.add('active');
                selectedOptions[attribute] = value;
                selectedVariant = findMatchingVariant();
                if (selectedVariant) {
                    updatePrice(selectedVariant);
                    updateAddToCartForm(selectedVariant);
                    updateAddToCartButton(selectedVariant);
                }
            });
        });
        function findMatchingVariant() {
            return variants.find(variant => {
                for (let key in selectedOptions) {
                    if (variant[key] !== selectedOptions[key]) return false;
                }
                return true;
            });
        }
        function updatePrice(variant) {
            let priceHtml = '';
            const salePrice = parseFloat(variant.sale_price);
            const regularPrice = parseFloat(variant.regular_price);
            if (variant.on_sale && salePrice < regularPrice) {
                priceHtml = `<span class="current-price">$${salePrice.toFixed(2)}</span>
                             <span class="old-price" style="text-decoration: line-through; color: #999;">$${regularPrice.toFixed(2)}</span>`;
            } else {
                priceHtml = `<span class="current-price">$${regularPrice.toFixed(2)}</span>`;
            }
            if (priceElement) priceElement.innerHTML = priceHtml;
        }
        function updateAddToCartForm(variant) {
            const priceInput = document.querySelector('form[name="addtocart-form"] input[name="price"]');
            if (priceInput) {
                priceInput.value = variant.on_sale ? variant.sale_price : variant.regular_price;
            }
            variantIdInput.value = variant.id;
        }
        // function updateAddToCartButton(variant) {
        //     const addToCartContainer = document.getElementById('add-to-cart-container');
        //     const isInCart = cartItems.some(item => item.options.variant_id == variant.id);
        //     addToCartContainer.innerHTML = '';
        //     if (isInCart) {
        //         const goToCartBtn = document.createElement('a');
        //         goToCartBtn.href = "{{ route('cart.index') }}";
        //         goToCartBtn.className = "btn btn-warning mb-3 btn-go-to-cart";
        //         goToCartBtn.innerText = "Ir al carrito";
        //         addToCartContainer.appendChild(goToCartBtn);
        //     } else {
        //         const addToCartFormHtml = `
        //             <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
        //                 @csrf
        //                <div class="product-single__addtocart">
        //                     <div class="qty-control position-relative">
        //                         <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center">
        //                         <div class="qty-control__reduce">-</div>
        //                         <div class="qty-control__increase">+</div>
        //                     </div>
        //                     <input type="hidden" name="id" value="{{ $product->id }}"/>
        //                     <input type="hidden" name="name" value="{{ $product->name }}"/>
        //                     <input type="hidden" name="price" value="${variant.on_sale ? variant.sale_price : variant.regular_price}"/>
        //                     <input type="hidden" name="variant_id" id="variant-id-input" value="${variant.id}"/> 
        //                     <button type="submit" class="btn btn-primary btn-addtocart" data-aside="cartDrawer">Añadir al carrito</button>
        //                 </div>
        //            </form>
        //         `;
        //         addToCartContainer.innerHTML = addToCartFormHtml;
        //     }
        // }
async function updateAddToCartButton(variant) {
    const addToCartContainer = document.getElementById('add-to-cart-container');
    if (!variant) {
        // Si no hay una variante seleccionada, mostramos un mensaje para que el usuario la elija
        addToCartContainer.innerHTML = `<button type="button" disabled class="btn btn-primary btn-addtocart">Seleccione una variante</button>`;
        return;
    }
    try {
        const response = await fetch("{{ route('cart.content') }}");
        const updatedCartItems = await response.json();
        const isInCart = Object.values(updatedCartItems).some(item => {
            // Comprobamos si el item del carrito tiene una variante asociada y si coincide con la variante seleccionada
            return item.options && item.options.variant_id == variant.id;
        });
        addToCartContainer.innerHTML = ''; // Limpiamos el contenido anterior del contenedor
        if (isInCart) {
            // Si la variante está en el carrito, mostramos el botón "Ir al carrito"
            const goToCartBtn = document.createElement('a');
            goToCartBtn.href = "{{ route('cart.index') }}";
            goToCartBtn.className = "btn btn-warning btn-go-to-cart";
            goToCartBtn.innerText = "Ir al carrito";
            addToCartContainer.appendChild(goToCartBtn);
        } else {
            // Si no está, mostramos el formulario "Añadir al carrito"
            const addToCartFormHtml = `
                <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
                    @csrf
                    <div class="product-single__addtocart">
                        <div class="qty-control position-relative">
                            <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center">
                            <div class="qty-control__reduce">-</div>
                            <div class="qty-control__increase">+</div>
                        </div>
                        <input type="hidden" name="id" value="{{ $product->id }}"/>
                        <input type="hidden" name="name" value="{{ $product->name }}"/>
                        <input type="hidden" name="price" value="${variant.on_sale ? variant.sale_price : variant.regular_price}"/>
                        <input type="hidden" name="variant_id" id="variant-id-input" value="${variant.id}"/>
                        <button type="submit" class="btn btn-primary btn-addtocart" data-aside="cartDrawer">Añadir al carrito</button>
                    </div>
                </form>
            `;
            addToCartContainer.innerHTML = addToCartFormHtml;
        }
    } catch (error) {
        console.error("Error al obtener el contenido del carrito:", error);
        // En caso de error, muestra el formulario de "Añadir al carrito" por defecto para no dejar al usuario sin opción.
        const defaultFormHtml = `
            <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
                @csrf
                <div class="product-single__addtocart">
                    <div class="qty-control position-relative">
                        <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center">
                        <div class="qty-control__reduce">-</div>
                        <div class="qty-control__increase">+</div>
                    </div>
                    <input type="hidden" name="id" value="{{ $product->id }}"/>
                    <input type="hidden" name="name" value="{{ $product->name }}"/>
                    <input type="hidden" name="price" value="${variant.on_sale ? variant.sale_price : variant.regular_price}"/>
                    <input type="hidden" name="variant_id" id="variant-id-input" value="${variant.id}"/>
                    <button type="submit" class="btn btn-primary btn-addtocart" data-aside="cartDrawer">Añadir al carrito</button>
                </div>
            </form>
        `;
        addToCartContainer.innerHTML = defaultFormHtml;
    }
}
        const firstColorButton = document.querySelector('.color-options .variant-option');
        if (firstColorButton) firstColorButton.click();
        const firstSizeButton = document.querySelector('.size-options .variant-option');
        if (firstSizeButton) firstSizeButton.click();
      });
</script>
@endpush

{{-- codigo original --}}

