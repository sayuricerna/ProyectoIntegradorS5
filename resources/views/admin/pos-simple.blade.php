@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h3>Registro de Venta Simple</h3>
            <hr>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <form id="pos-form" action="{{ route('admin.pos.process_simple_order') }}" method="POST">
                @csrf
                
                <div class="card mb-4">
                    <div class="card-header">
                        Información del Cliente
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Nombre del Cliente</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="Consumidor Final" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_cedula" class="form-label">Cédula</label>
                            <input type="text" class="form-control" id="customer_cedula" name="customer_cedula">
                        </div>
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone">
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Método de Pago</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="cash">Efectivo</option>
                                <option value="card">Tarjeta</option>
                                <option value="transfer">Transferencia</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        Agregar Productos
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="sku-input" placeholder="Ingrese el SKU del producto">
                            <button class="btn btn-outline-secondary" type="button" id="add-product-btn">Agregar</button>
                        </div>
                        <div id="product-details-container" class="mb-3">
                            {{-- Aquí se mostrarán los detalles del producto --}}
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        Productos en la Venta
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cart-table-body">
                                {{-- Aquí se agregarán las filas de los productos --}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Total:</th>
                                    <th id="cart-total">$0.00</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Inputs ocultos para enviar los productos al servidor --}}
                <div id="hidden-inputs-container"></div>
                
                <button type="submit" class="btn btn-success w-100">Registrar Venta</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const skuInput = document.getElementById('sku-input');
        const addProductBtn = document.getElementById('add-product-btn');
        const productDetailsContainer = document.getElementById('product-details-container');
        const cartTableBody = document.getElementById('cart-table-body');
        const hiddenInputsContainer = document.getElementById('hidden-inputs-container');
        const cartTotalDisplay = document.getElementById('cart-total');
        
        let cart = [];

        addProductBtn.addEventListener('click', function() {
            const sku = skuInput.value.trim();
            if (!sku) {
                alert('Por favor, ingrese un SKU.');
                return;
            }

            // Simula una búsqueda AJAX (aquí debes conectar con un endpoint real en tu controlador)
            // Por simplicidad, este es un ejemplo simulado
            // En la vida real, necesitarías una ruta como '/api/product-by-sku'
            // que devuelva el producto en formato JSON.
            fetch(`/admin/pos/search?query=${sku}`)
                .then(response => response.text())
                .then(html => {
                    // Esta respuesta es de la búsqueda del código anterior, por lo que no es JSON
                    // La lógica correcta sería una ruta que devuelva JSON con los datos del producto
                    // y aquí se usarían esos datos para agregarlos al carrito
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    const card = tempDiv.querySelector('.card-body');
                    const variantId = card.querySelector('.add-to-cart-btn').dataset.variantId;
                    const productName = card.querySelector('h5').textContent;
                    const price = parseFloat(card.querySelector('.card-text').textContent.split('$')[1]);
                    
                    const existingItem = cart.find(item => item.sku === sku);
                    if (existingItem) {
                        existingItem.quantity++;
                    } else {
                        cart.push({ sku, productName, price, quantity: 1 });
                    }
                    
                    skuInput.value = '';
                    updateCartUI();
                })
                .catch(error => {
                    alert('Producto no encontrado con el SKU: ' + sku);
                    console.error('Error:', error);
                });
        });

        function updateCartUI() {
            cartTableBody.innerHTML = '';
            hiddenInputsContainer.innerHTML = '';
            let total = 0;

            if (cart.length === 0) {
                cartTableBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No hay productos en la venta.</td></tr>';
            } else {
                cart.forEach((item, index) => {
                    const subtotal = item.price * item.quantity;
                    total += subtotal;

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.sku}</td>
                        <td>${item.productName}</td>
                        <td>
                            <input type="number" class="form-control form-control-sm" value="${item.quantity}" min="1" data-index="${index}" style="width: 70px;">
                        </td>
                        <td>$${item.price.toFixed(2)}</td>
                        <td>$${subtotal.toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-item-btn" data-index="${index}">Remover</button>
                        </td>
                    `;
                    cartTableBody.appendChild(row);

                    // Inputs ocultos para el servidor
                    hiddenInputsContainer.innerHTML += `
                        <input type="hidden" name="products[${index}][sku]" value="${item.sku}">
                        <input type="hidden" name="products[${index}][quantity]" value="${item.quantity}" id="quantity-input-${index}">
                    `;
                });
            }

            cartTotalDisplay.textContent = `$${total.toFixed(2)}`;
            attachListeners();
        }

        function attachListeners() {
            // Maneja cambios en la cantidad
            document.querySelectorAll('#cart-table-body input[type="number"]').forEach(input => {
                input.addEventListener('change', function() {
                    const index = this.dataset.index;
                    const newQuantity = parseInt(this.value);
                    if (newQuantity > 0) {
                        cart[index].quantity = newQuantity;
                        updateCartUI();
                    }
                });
            });

            // Maneja la remoción de productos
            document.querySelectorAll('.remove-item-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.dataset.index;
                    cart.splice(index, 1);
                    updateCartUI();
                });
            });
        }
        
        // Carga la lista inicial al cargar la página
        updateCartUI();
    });
</script>
@endsection