@extends('layouts.app')
@section('content')
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Shipping and Checkout</h2>
      <div class="checkout-steps">
        <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
        </a>
        <a href="javascript::void(0)" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
        </a>
        <a href="javascript::void(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
        </a>
      </div>
      <form name="checkout-form" action="{{ route('cart.place.order') }}" method="POST">
        @csrf
        <div class="checkout-form">
          <div class="billing-info__wrapper">
            <div class="row">
              <div class="col-6">
                <h4>SHIPPING DETAILS</h4>
              </div>
              <div class="col-6">
              </div>
            </div>
            @if ($address)
                <div class="row">
                    <div class="col-md-12">
                        <div class="my-account__address-list">
                            <div class="my-account__address-list-item">
                                <div class="my-account__address-item__detail">
                                    <p>{{$address->name}}</p>
                                    <p>{{$address->address}}</p>
                                    <p>{{$address->reference}}</p>
                                    <p>{{$address->city}}, {{$address->province}},{{$address->country}}</p>
                                    <p>{{$address->zip}}</p>
                                    <br/>
                                    <p>{{$address->phone}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <div class="row mt-5">
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="name" required="" value="{{ old('name') }}">
                  <label for="name">Nombres y Apellidos *</label>
                    @error('name') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="phone" required="" value="{{ old('phone') }}">
                  <label for="phone">Teléfono celular *</label>
                  @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="zip" required="" value="{{ old('zip') }}">
                  <label for="zip">ZIPCode *</label>
                  @error('zip') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating mt-3 mb-3">
                  <input type="text" class="form-control" name="province" required="" value="{{ old('province') }}">
                  <label for="province">Provincia *</label>
                  @error('province') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="city" required="" value="{{ old('city') }}">
                  <label for="city">Ciudad *</label>
                  @error('city') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="address" required="" value="{{ old('address') }}">
                  <label for="address">Dirección *</label>
                  @error('address') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="reference" required="" value="{{ old('reference') }}">
                  <label for="reference">Referencia </label>
                  @error('reference') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              
            </div>
            @endif
          </div>
          <div class="checkout__totals-wrapper">
            <div class="sticky-content">
              <div class="checkout__totals">
                <h3>Your Order</h3>
                <table class="checkout-cart-items">
                  <thead>
                    <tr>
                      <th>PRODUCT</th>
                      <th align="right">SUBTOTAL</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach (Cart::instance('cart') as $item)
                    <tr>
                      <td>
                       {{$item->name}} x {{$item->qty}}
                      </td>
                      <td align="right">
                        ${{$item->subtotal()}}
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <table class="checkout-totals">
                  <tbody>
                    <tr>
                      <th>SUBTOTAL</th>
                      <td class="text-right">{{Cart::instance('cart')->subtotal()}}</td>
                    </tr>
                    <tr>
                      <th>SHIPPING</th>
                      <td class="text-right">Free shipping</td>
                    </tr>
                    <tr>
                      <th>IVA(15%)</th>
                      <td class="text-right">{{Cart::instance('cart')->tax()}}</td>
                    </tr>
                    <tr>
                      <th>TOTAL</th>
                      <td class="text-right">{{Cart::instance('cart')->total()}}</td>
                    </tr>
                  </tbody>
                </table>
                
              </div>
              <div class="checkout__payment-methods">
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode1" value="stripe">
                  <label class="form-check-label" for="mode1">
                    Pago en Línea
                  </label>
                </div>
                       
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode2" value="tranference">
                  <label class="form-check-label" for="mode2">
                    Transferencia
                  </label>
                </div>
              </div>
              <button class="btn btn-primary btn-checkout">Proceder con checkout</button>
            </div>
          </div>
        </div>
      </form>
    </section>
  </main>
@endsection