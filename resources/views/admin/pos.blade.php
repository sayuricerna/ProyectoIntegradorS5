{{-- @extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Punto de Venta</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.pos.add') }}"><div class="text-tiny">Punto de Venta</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Añadir Pedido</div></li>
            </ul>
        </div>
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.pos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <fieldset class="name"> 
                    <div class="body-title">Buscar Producto o SKU <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Ingrese el nombre del producto o SKU" name="product_search" id="product_search" tabindex="0" value="{{ old('product_search') }}" aria-required="true" required="">
                </fieldset>
                @error('product_search') <span class='alert alert-danger text-center'>{{$message}}</span>@enderror
                <div id="product_results" class="mt-4"></div>
                <fieldset class="name mt-4">
                    <div class="body-title">Cliente <span class="tf-color-1">*</span></div>
                    <select class="flex-grow" name="client_id" id="client_id" required  >
                        <option value="">Seleccione un cliente</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} - {{ $client->email }}
                            </option>
                        @endforeach
                    </select>
                </fieldset>
                @error('client_id') <span class='alert alert-danger text-center'>{{$message}}</span>@enderror
                <div class="bot mt-4">
                    <div></div>
                    <button class="tf-button w208" type="submit">Crear Pedido</button>
                    <a href="{{ route('admin.pos') }}" class="tf-button w208">Cancelar</a>        
                </div>
            </form>
        </div>
@endsection --}}

@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-7">
            <h3>Buscar productos</h3>
            <div class="input-group mb-3">
                <input type="text" id="product-search" class="form-control" placeholder="Buscar por nombre o SKU...">
                <button class="btn btn-outline-secondary" type="button">Buscar</button>
            </div>
            
            <div class="row" id="products-list">
                {{-- Aquí se mostrarán los productos encontrados, por ahora muestra una lista paginada --}}
                @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('uploads/products/thumbnails/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            @foreach ($product->variants as $variant)
                            <p class="card-text">
                                SKU: {{ $variant->sku }} <br>
                                Precio: ${{ $variant->regular_price }} <br>
                                Stock: {{ $variant->quantity }}
                            </p>
                            <button class="btn btn-primary btn-sm add-to-cart-btn" 
                                data-variant-id="{{ $variant->id }}"
                                data-product-name="{{ $product->name }}"
                                data-sku="{{ $variant->sku }}"
                                data-price="{{ $variant->regular_price }}">
                                Añadir al Carrito
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>

        <div class="col-md-5">
            <h3>Carrito de Compra</h3>
            <form action="{{ route('admin.pos.process_order') }}" method="POST">
                @csrf
                <div id="cart-items" class="mb-3">
                    <p class="text-muted">El carrito está vacío.</p>
                </div>
                
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Nombre del Cliente</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name">
                </div>
                <div class="mb-3">
                    <label for="customer_email" class="form-label">Email del Cliente</label>
                    <input type="email" class="form-control" id="customer_email" name="customer_email">
                </div>
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Método de Pago</label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        <option value="cash">Efectivo</option>
                        <option value="card">Tarjeta</option>
                        <option value="transfer">Transferencia</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <h4>Total:</h4>
                    <h4 id="cart-total">$0.00</h4>
                </div>
                
                <button type="submit" class="btn btn-success w-100" id="checkout-btn">Procesar Venta</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cartItemsContainer = document.getElementById('cart-items');
        const cartTotalDisplay = document.getElementById('cart-total');
        let cart = [];

        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function() {
                const variantId = this.dataset.variantId;
                const productName = this.dataset.productName;
                const sku = this.dataset.sku;
                const price = parseFloat(this.dataset.price);

                const existingItem = cart.find(item => item.variant_id === variantId);

                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        variant_id: variantId,
                        product_name: productName,
                        sku: sku,
                        price: price,
                        quantity: 1
                    });
                }
                updateCartUI();
            });
        });

        function updateCartUI() {
            cartItemsContainer.innerHTML = '';
            let total = 0;

            if (cart.length === 0) {
                cartItemsContainer.innerHTML = '<p class="text-muted">El carrito está vacío.</p>';
            } else {
                cart.forEach((item, index) => {
                    const subtotal = item.price * item.quantity;
                    total += subtotal;

                    const itemHtml = `
                        <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                            <div>
                                <h5>${item.product_name} (${item.sku})</h5>
                                <p class="mb-0">$${item.price} x ${item.quantity}</p>
                                <input type="hidden" name="products[${index}][variant_id]" value="${item.variant_id}">
                                <input type="hidden" name="products[${index}][quantity]" value="${item.quantity}">
                            </div>
                            <button type="button" class="btn btn-danger btn-sm remove-from-cart-btn" data-index="${index}">Remover</button>
                        </div>
                    `;
                    cartItemsContainer.innerHTML += itemHtml;
                });
            }

            cartTotalDisplay.textContent = `$${total.toFixed(2)}`;
            attachRemoveListeners();
        }

        function attachRemoveListeners() {
            document.querySelectorAll('.remove-from-cart-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.dataset.index;
                    cart.splice(index, 1);
                    updateCartUI();
                });
            });
        }
    });
</script>
@endsection