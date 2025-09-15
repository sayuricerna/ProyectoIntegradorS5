@extends('layouts.app')
@section('content')
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Envío y Checkout</h2>
      <div class="checkout-steps">
        <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
          <span class="checkout-steps__item-title">Carrito de Compras</span>
        </a>
          <a href="javascript:void(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-title">Datos para el envío</span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-title">Confirmación </span>
        </a>
      </div>
      <form name="checkout-form" id="payment-form" action="{{ route('cart.place.order') }}" method="POST">
        @csrf
        {{-- Mensajes de error/éxito de la sesión --}}
        @if(session('error'))
            <div class="alert alert-danger mb-4">
                {{ session(key: 'error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="checkout-form">
          <div class="billing-info__wrapper">
            <div class="row">
              <div class="col-6">
                <h4>Detales de Envío</h4>
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
                                    <p>{{$address->cedula}}</p>
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
              <div class="col-md-3">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="cedula" required="" value="{{ old('cedula') }}">
                  <label for="cedula">Cedula </label>
                  @error('cedula') <span class="text-danger">{{$message}}</span> @enderror
                </div>
              </div>
              <div class="col-md-3">
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
                <h3>Su pedido</h3>
                <table class="checkout-cart-items">
                  <thead>
                    <tr>
                      <th>PRODUCTO</th>
                      <th align="right">SUBTOTAL</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach (Cart::instance('cart') as $item)
                    {{-- @foreach (Cart::instance('cart')->content() as $item) --}}
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
                      <td class="text-right">${{Cart::instance('cart')->subtotal()}}</td>
                    </tr>
                    <tr>
                      <th>ENVÍO</th>
                      <td class="text-right">Gratis</td>
                    </tr>
                    <tr>
                      <th>IVA(15%)</th>
                      <td class="text-right">${{Cart::instance('cart')->tax()}}</td>
                    </tr>
                    <tr>
                      <th>TOTAL</th>
                      <td class="text-right">${{Cart::instance('cart')->total()}}</td>
                    </tr>
                  </tbody>
                </table>
                
              </div>
              {{-- <div class="checkout__payment-methods">
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
              <button class="btn btn-primary btn-checkout">Continuar</button> --}}

              <div class="checkout__payment-methods">
                {{-- Radio button para Stripe (Pago en Línea) --}}
                <div class="form-check">
                    {{-- Le asigné un ID 'mode_stripe' para referenciarlo en JS. 'checked' para que sea la opción por defecto. --}}
                    <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode_stripe" value="stripe" checked>
                    <label class="form-check-label" for="mode_stripe">
                        Pago con Tarjeta de Crédito/Débito
                    </label>
                </div>

                {{-- Contenedor para los elementos de tarjeta de Stripe.js --}}
                {{-- Este div inicialmente será visible si 'mode_stripe' está checked --}}
                <div id="stripe-card-element" style="border: 1px solid #e0e0e0; padding: 15px; margin-top: 15px; border-radius: 5px; background-color: #f9f9f9;">
                    <p style="font-size: 0.9em; color: #555;">Ingresa los detalles de tu tarjeta:</p>
                    {{-- Los elementos de tarjeta se inyectarán aquí --}}
                </div>
                {{-- Aquí se mostrarán los errores de la tarjeta --}}
                <div id="card-errors" role="alert" style="color: red; margin-top: 10px; font-size: 0.9em;"></div>

                {{-- Radio button para Transferencia --}}
                <div class="form-check mt-3">
                    {{-- Le asigné un ID 'mode_tranference' para referenciarlo en JS. --}}
                    <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode_tranference" value="tranference">
                    <label class="form-check-label" for="mode_tranference">
                        Transferencia Bancaria
                    </label>
                </div>

              </div>
              {{-- boton de confirmacion  --}}
              <button type="submit" class="btn btn-primary btn-checkout" id="submit-button">Realizar Pedido</button>
           </div>
          </div>
        </div>
      </form>
    </section>
  </main>
@endsection
@push('scripts') 
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ $stripeKey }}');
    const elements = stripe.elements();

    const style = {
        base: {
            color: '#32325d',
            fontFamily: 'Arial, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    const card = elements.create('card', { style: style });

    card.mount('#stripe-card-element');

    card.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    const paymentModeRadios = document.querySelectorAll('input[name="mode"]');
    const stripeCardElementDiv = document.getElementById('stripe-card-element');
    const submitButton = document.getElementById('submit-button');

    function updateStripeVisibility() {
        const selectedMode = document.querySelector('input[name="mode"]:checked').value;
        if (selectedMode === 'stripe') {
            stripeCardElementDiv.style.display = 'block';
            // Puedes añadir lógica aquí para deshabilitar el botón si el formulario de tarjeta no es válido
            // Aunque Stripe.js ya lo gestiona antes de la creación del PaymentMethod
        } else {
            stripeCardElementDiv.style.display = 'none';
            submitButton.disabled = false; // Asegúrate de que el botón esté habilitado para otros modos
        }
    }

    // Añade event listeners a los radio buttons
    paymentModeRadios.forEach(radio => {
        radio.addEventListener('change', updateStripeVisibility);
    });

    updateStripeVisibility();

    const form = document.forms['checkout-form']; // Referencia al formulario por su atributo 'name'
    form.addEventListener('submit', async function(event) {
        event.preventDefault(); // IMPIDE EL ENVÍO NORMAL DEL FORMULARIO
        submitButton.disabled = true; // Deshabilita el botón para evitar doble envío
        document.getElementById('card-errors').textContent = ''; // Limpia errores previos

        const selectedMode = document.querySelector('input[name="mode"]:checked').value;

        if (selectedMode === 'stripe') {
            // Si el modo es Stripe, crea el PaymentMethod
            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
                billing_details: {
                    name: document.querySelector('input[name="name"]') ? document.querySelector('input[name="name"]').value : '{{ Auth::user()->name ?? "" }}',
                    email: '{{ Auth::user()->email ?? "" }}',

                },
            });

            if (error) {
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
                submitButton.disabled = false; 
            } else {
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method_id');
                hiddenInput.setAttribute('value', paymentMethod.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        } else {
            form.submit();
        }
    });
</script>
@endpush