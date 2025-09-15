@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('admin.products') }}">
                        <div class="text-tiny">Productos</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Editar</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
            action="{{ route('admin.product.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $product->id }}"/>
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Nombre<span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Nombre de producto"
                        name="name" tabindex="0" value="{{ old('name', $product->name) }}" aria-required="true" required="">
                    <div class="text-tiny">Max 100 Caracteres.</div>
                </fieldset>
                @error('name') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enlace interno para tienda"
                        name="slug" tabindex="0" value="{{ old('slug', $product->slug) }}" aria-required="true" required="">
                    <div class="text-tiny">Max 100c</div>
                </fieldset>
                @error('slug') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Categoría <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select class="" name="category_id">
                                <option>Escoger categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? "selected" : "" }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error('category_id') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror
                    
                    <fieldset class="brand">
                        <div class="body-title mb-10">Marca <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select class="" name="brand_id">
                                <option>Escoger Marca</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? "selected" : "" }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error('brand_id') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror
                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Descripción Visible<span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="short_description"
                        placeholder="Descripción corta del producto" tabindex="0" aria-required="true"
                        required="">{{ old('short_description', $product->short_description) }}</textarea>
                    <div class="text-tiny">max 50c</div>
                </fieldset>
                @error('short_description') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror

                <fieldset class="description">
                    <div class="body-title mb-10">Descripción <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10" name="description" placeholder="Descripción"
                        tabindex="0" aria-required="true" required="">{{ old('description', $product->description) }}</textarea>
                    <div class="text-tiny">max 100c</div>
                </fieldset>
                @error('description') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror
            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Imagen Principal <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        @if ($product->image)
                        <div class="item" id="imgpreview">
                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                class="effect8" alt="">
                        </div>
                        @else
                        <div class="item" id="imgpreview" style="display: none;">
                            <img src="#" class="effect8" alt="">
                        </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Subir <span class="tf-color"> </span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror

                <fieldset>
                    <div class="body-title mb-10">Imagenes de Grid</div>
                    <div class="upload-image mb-16">
                        @if ($product->images)
                        @foreach (explode(',', $product->images) as $img)
                        <div class="item gitems">
                            <img src="{{ asset('uploads/products/' . trim($img)) }}" alt="">
                        </div>
                        @endforeach
                        @endif
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Subir<span class="tf-color"> </span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*"
                                    multiple="">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('images') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror

                <div class="wg-box">
                    <div class="body-title mb-10">Tipo de Producto</div>
                    <div class="select mb-10">
                        <select id="productType" name="product_type" disabled>
                            {{-- Deshabilitar la opción para que no se pueda cambiar el tipo de producto --}}
                            <option value="single" {{ $product->variants->count() == 1 ? "selected" : "" }}>
                                Producto Único
                            </option>
                            <option value="variant" {{ $product->variants->count() > 1 ? "selected" : "" }}>
                                Producto con Variantes
                            </option>
                        </select>
                    </div>
                </div>

                {{-- <div id="single-product-fields" style="{{ $product->variants->count() == 1 ? 'display: block;' : 'display: none;' }}">
                    @php
                        $variant = $product->variants->first();
                    @endphp
                    <input type="hidden" name="variants[0][id]" value="{{ $variant->id }}">
                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Precio <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Precio normal"
                                name="regular_price" tabindex="0" value="{{ old('regular_price', $variant->regular_price) }}"
                                aria-required="true" required="">
                        </fieldset>
                        @error('regular_price') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror
                        
                        <fieldset class="name">
                            <div class="body-title mb-10">Precio Descuento <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Precio en Oferta"
                                name="sale_price" tabindex="0" value="{{ old('sale_price', $variant->sale_price) }}"
                                aria-required="true">
                        </fieldset>
                        @error('sale_price') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">En Oferta</div>
                            <div class="mb-10">
                                <input type="hidden" name="on_sale" value="0">
                                <input type="checkbox" name="on_sale" value="1" {{ old('on_sale', $variant->on_sale) ? 'checked' : '' }}>
                            </div>
                        </fieldset>
                        
                        <fieldset class="name">
                            <div class="body-title mb-10"># para almacén <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Cod. para almacen" name="sku"
                                tabindex="0" value="{{ old('sku', $variant->sku) }}" aria-required="true" required="">
                        </fieldset>
                        @error('sku') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Cantidad de Unidades <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Cantidad de Unidades"
                                name="quantity" tabindex="0" value="{{ old('quantity', $variant->quantity) }}"
                                aria-required="true" required="">
                        </fieldset>
                        @error('quantity') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror
                        
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status">
                                    <option value="instock" {{ old('stock_status', $variant->stock_status) == "instock" ? "selected" : "" }}>En Stock</option>
                                    <option value="outofstock" {{ old('stock_status', $variant->stock_status) == "outofstock" ? "selected" : "" }}>Fuera de Stock</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('stock_status') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror
                    </div>
                </div> --}}
<div id="single-product-fields" style="{{ $product->variants->count() == 1 ? 'display: block;' : 'display: none;' }}">
    @php
        $variant = $product->variants->first();
    @endphp

    <input type="hidden" name="variants[id]" value="{{ $variant->id }}">
    <div class="cols gap22">
        <fieldset class="name">
            <div class="body-title mb-10">Precio <span class="tf-color-1">*</span></div>
            <input class="mb-10" type="text" placeholder="Precio normal"
                name="variants[regular_price]" tabindex="0" 
                value="{{ old('variants.regular_price', $variant->regular_price ?? '') }}"
                aria-required="true" required="">
        </fieldset>
        @error('variants.regular_price') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror

        <fieldset class="name">
            <div class="body-title mb-10">Precio Descuento</div>
            <input class="mb-10" type="text" placeholder="Precio en Oferta"
                name="variants[sale_price]" tabindex="0" 
                value="{{ old('variants.sale_price', $variant->sale_price ?? '') }}">
        </fieldset>
        @error('variants.sale_price') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror
    </div>

    <div class="cols gap22">
        <fieldset class="name">
            <div class="body-title mb-10">En Oferta</div>
            <div class="mb-10">
                <input type="hidden" name="variants[on_sale]" value="0">
                <input type="checkbox" name="variants[on_sale]" value="1" 
                    {{ old('variants.on_sale', $variant->on_sale ?? false) ? 'checked' : '' }}>
            </div>
        </fieldset>

        <fieldset class="name">
            <div class="body-title mb-10"># para almacén <span class="tf-color-1">*</span></div>
            <input class="mb-10" type="text" placeholder="Cod. para almacen" 
                name="variants[sku]" tabindex="0" 
                value="{{ old('variants.sku', $variant->sku ?? '') }}" 
                aria-required="true" required="">
        </fieldset>
        @error('variants.sku') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror
    </div>

    <div class="cols gap22">
        <fieldset class="name">
            <div class="body-title mb-10">Cantidad de Unidades <span class="tf-color-1">*</span></div>
            <input class="mb-10" type="text" placeholder="Cantidad de Unidades"
                name="variants[quantity]" tabindex="0" 
                value="{{ old('variants.quantity', $variant->quantity ?? '') }}"
                aria-required="true" required="">
        </fieldset>
        @error('variants.quantity') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror

        <fieldset class="name">
            <div class="body-title mb-10">Stock</div>
            <div class="select mb-10">
                <select class="" name="variants[stock_status]">
                    <option value="instock" {{ (old('variants.stock_status', $variant->stock_status ?? '')) == "instock" ? "selected" : "" }}>En Stock</option>
                    <option value="outofstock" {{ (old('variants.stock_status', $variant->stock_status ?? '')) == "outofstock" ? "selected" : "" }}>Fuera de Stock</option>
                </select>
            </div>
        </fieldset>
        @error('variants.stock_status') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror
    </div>
</div>

                <div id="variant-product-fields" style="{{ $product->variants->count() > 1 ? 'display: block;' : 'display: none;' }}">
                    <button type="button" class="tf-button style-1 h50" id="addVariant">
                        Añadir Variante
                    </button>
                    <div id="variantsContainer">
                        {{-- Las variantes existentes se cargarán aquí --}}
                        @foreach ($product->variants as $variant)
                            <div class="variant-item-wrapper mb-20" data-id="{{ $variant->id }}">
                                <input type="hidden" name="variants[{{ $loop->index }}][id]" value="{{ $variant->id }}">
                                <div class="wg-box">
                                    <div class="body-title mb-10">Variante #{{ $loop->index + 1 }}</div>
                                    <a href="#" class="remove-variant">Remover</a>
                                    <div class="cols gap22">
                                        <fieldset>
                                            <div class="body-title mb-10">SKU</div>
                                            <input type="text" name="variants[{{ $loop->index }}][sku]" class="mb-10" value="{{ old('variants.' . $loop->index . '.sku', $variant->sku) }}" required>
                                        </fieldset>
                                        <fieldset>
                                            <div class="body-title mb-10">Precio</div>
                                            <input type="text" name="variants[{{ $loop->index }}][regular_price]" class="mb-10" value="{{ old('variants.' . $loop->index . '.regular_price', $variant->regular_price) }}" required>
                                        </fieldset>
                                    </div>
                                    <div class="cols gap22">
                                        <fieldset>
                                            <div class="body-title mb-10">Precio Descuento</div>
                                            <input type="text" name="variants[{{ $loop->index }}][sale_price]" class="mb-10" value="{{ old('variants.' . $loop->index . '.sale_price', $variant->sale_price) }}">
                                        </fieldset>
                                        <fieldset>
                                            <div class="body-title mb-10">En Oferta</div>
                                            <input type="hidden" name="variants[{{ $loop->index }}][on_sale]" value="0">
                                            <input type="checkbox" name="variants[{{ $loop->index }}][on_sale]" value="1" {{ old('variants.' . $loop->index . '.on_sale', $variant->on_sale) ? 'checked' : '' }}>
                                        </fieldset>
                                    </div>
                                    <div class="cols gap22">
                                        <fieldset>
                                            <div class="body-title mb-10">Cantidad</div>
                                            <input type="number" name="variants[{{ $loop->index }}][quantity]" class="mb-10" value="{{ old('variants.' . $loop->index . '.quantity', $variant->quantity) }}" required>
                                        </fieldset>
                                        <fieldset>
                                            <div class="body-title mb-10">Stock</div>
                                            <div class="select">
                                                <select name="variants[{{ $loop->index }}][stock_status]">
                                                    <option value="instock" {{ old('variants.' . $loop->index . '.stock_status', $variant->stock_status) == 'instock' ? 'selected' : '' }}>En Stock</option>
                                                    <option value="outofstock" {{ old('variants.' . $loop->index . '.stock_status', $variant->stock_status) == 'outofstock' ? 'selected' : '' }}>Fuera de Stock</option>
                                                </select>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="cols gap22">
                                        <fieldset>
                                            <div class="body-title mb-10">Color</div>
                                            <input type="text" name="variants[{{ $loop->index }}][color]" class="mb-10" value="{{ old('variants.' . $loop->index . '.color', $variant->color) }}">
                                        </fieldset>
                                        <fieldset>
                                            <div class="body-title mb-10">Talla/Tamaño</div>
                                            <input type="text" name="variants[{{ $loop->index }}][size]" class="mb-10" value="{{ old('variants.' . $loop->index . '.size', $variant->size) }}">
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <fieldset class="name">
                    <div class="body-title mb-10">Producto Destacado</div>
                    <div class="select mb-10">
                        <select class="" name="featured">
                            <option value="0" {{ old('featured', $product->featured) == "0" ? "selected" : "" }}>No</option>
                            <option value="1" {{ old('featured', $product->featured) == "1" ? "selected" : "" }}>Sí</option>
                        </select>
                    </div>
                </fieldset>
                @error('featured') <span class='alert alert-danger text-center'>{{ $message }}</span> @enderror
            </div>

            <div class="cols gap10">
                <button class="tf-button w-full" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</div>

@endsection

{{-- para gen slug  --}}
@push('scripts')
<script>
    $(function() {
        $("#myFile").on("change",function(e){
            const photoInp = $("#myFile");
            const [file] = this.files;
            if(file){
                $("#imgpreview img").attr('src',URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });
        $("#gFile").on("change",function(e){
            const photoInp = $("#gFile");
            const gphotos = this.files;
            $.each(gphotos,function(key,val){
                $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}"></div>`)
            });
        });
        $("input[name='name']").on("change",function(){
            $("input[name='slug']").val(StringToSlug($(this).val()));
        })
        
    });
    function StringToSlug(Text)
    {
        return Text.toLowerCase()
        .replace(/[^\w ]+/g,"")
        .replace(/ +/g,"-");
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const variantsContainer = document.getElementById('variantsContainer');
        const addVariantBtn = document.getElementById('addVariant');
        let variantIndex = variantsContainer.children.length;
        addVariantBtn.addEventListener('click', function () {
            const newVariantHtml = `
                <div class="variant-item-wrapper mb-20" data-id="new">
                    <div class="wg-box">
                        <div class="body-title mb-10">Nueva Variante</div>
                        <a href="#" class="remove-variant">Remover</a>
                        <div class="cols gap22">
                            <fieldset>
                                <div class="body-title mb-10">SKU</div>
                                <input type="text" name="variants[${variantIndex}][sku]" class="mb-10" required>
                            </fieldset>
                            <fieldset>
                                <div class="body-title mb-10">Precio</div>
                                <input type="text" name="variants[${variantIndex}][regular_price]" class="mb-10" required>
                            </fieldset>
                        </div>
                        <div class="cols gap22">
                            <fieldset>
                                <div class="body-title mb-10">Precio Descuento</div>
                                <input type="text" name="variants[${variantIndex}][sale_price]" class="mb-10">
                            </fieldset>
                            <fieldset>
                                <div class="body-title mb-10">En Oferta</div>
                                <input type="hidden" name="variants[${variantIndex}][on_sale]" value="0">
                                <input type="checkbox" name="variants[${variantIndex}][on_sale]" value="1">
                            </fieldset>
                        </div>
                        <div class="cols gap22">
                            <fieldset>
                                <div class="body-title mb-10">Cantidad</div>
                                <input type="number" name="variants[${variantIndex}][quantity]" class="mb-10" required>
                            </fieldset>
                            <fieldset>
                                <div class="body-title mb-10">Stock</div>
                                <div class="select">
                                    <select name="variants[${variantIndex}][stock_status]">
                                        <option value="instock">En Stock</option>
                                        <option value="outofstock">Fuera de Stock</option>
                                    </select>
                                </div>
                            </fieldset>
                        </div>
                        <div class="cols gap22">
                            <fieldset>
                                <div class="body-title mb-10">Color</div>
                                <input type="text" name="variants[${variantIndex}][color]" class="mb-10">
                            </fieldset>
                            <fieldset>
                                <div class="body-title mb-10">Talla/Tamaño</div>
                                <input type="text" name="variants[${variantIndex}][size]" class="mb-10">
                            </fieldset>
                        </div>
                    </div>
                </div>
            `;
            variantsContainer.insertAdjacentHTML('beforeend', newVariantHtml);
            variantIndex++;
        });

        variantsContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-variant')) {
                e.preventDefault();
                e.target.closest('.variant-item-wrapper').remove();
            }
        });
    });
</script>
@endpush