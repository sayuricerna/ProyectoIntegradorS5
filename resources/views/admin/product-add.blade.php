@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Añadir Producto</h3>
            {{-- <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
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
                    <div class="text-tiny"></div>
                </li>
            </ul> --}}
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
            action="{{ route('admin.product.store') }}">
            @csrf

            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Nombre <span class="tf-color-1">*</span>
                    </div>
                    <input class="mb-10" type="text" placeholder="Nombre de producto"
                        name="name" tabindex="0" value="{{ old('name') }}" aria-required="true" required="">
                    <div class="text-tiny">Max 100 Caracteres</div>
                </fieldset>
                    @error('name') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror

                {{-- <fieldset class="name">
                    <div class="body-title mb-10">Enlace SLUG <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enlace interno para tienda"
                        name="slug" tabindex="0" value="{{ old('slug') }}" aria-required="true" required="">
                    <div class="text-tiny">Max 100c</div>
                </fieldset>
                    @error('slug') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror --}}

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Categoría <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="category_id">
                                <option>Escoger categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error('category_id') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                    <fieldset class="brand">
                        <div class="body-title mb-10">Marca <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="brand_id">
                                <option>Escoger Marca</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error('brand_id') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Descripción Visible <span
                            class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="short_description"
                        placeholder="Descripción corta del producto" tabindex="0" aria-required="true"
                        required="">{{ old('short_description') }}</textarea>
                    <div class="text-tiny">max 50c</div>
                </fieldset>
                @error('short_description') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror

                <fieldset class="description">
                    <div class="body-title mb-10">Descripción <span class="tf-color-1">*</span>
                    </div>
                    <textarea class="mb-10" name="description" placeholder="Description"
                        tabindex="0" aria-required="true" required="">{{ old('description') }}</textarea>
                    <div class="text-tiny">max 100c</div>
                </fieldset>
                @error('description') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Imagen Principal<span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="../../../localhost_8000/images/upload/upload-1.png"
                                class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Subir<span
                                        class="tf-color"></span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror

                <fieldset>
                    <div class="body-title mb-10">Imagenes de Grid</div>
                    <div class="upload-image mb-16">
                        <!-- <div class="item">
        <img src="images/upload/upload-1.png" alt="">
    </div>                                                 -->
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Subir<span
                                        class="tf-color">
                                        </span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*"
                                    multiple="">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('images') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                {{-- <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Precio<span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Precio normal"
                            name="regular_price" tabindex="0" value="{{ old('regular_price') }}" aria-required="true"
                            required="">
                    </fieldset>
                    @error('regular_price') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Precio Descuento<span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Precio en Oferta"
                            name="sale_price" tabindex="0" value="{{ old('sale_price') }}" aria-required="true"
                            required="">
                    </fieldset>
                    @error('sale_price') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">¿Activar Oferta?</div>
                        <label class="switch">
                            <input type="checkbox" name="on_sale" value="1">
                            <span class="slider round"></span>
                        </label>
                        <div class="text-tiny mt-1">Marca esta casilla para mostrar el precio de descuento.</div>
                    </fieldset>
                </div>


                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10"># para almacén<span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Cod. para almacen" name="sku"
                            tabindex="0" value="{{ old('sku') }}" aria-required="true" required="">
                    </fieldset>
                    @error('sku') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Cantidad de Unidades <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Cantidad de Unidades"
                            name="quantity" tabindex="0" value="{{ old('quantity') }}" aria-required="true"
                            required="">
                    </fieldset>
                    @error('quantity') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock</div>
                        <div class="select mb-10">
                            <select class="" name="stock_status">
                                <option value="instock">En Stock</option>
                                <option value="outofstock">Fuera de Stock</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('stock_status') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Featured</div>
                        <div class="select mb-10">
                            <select class="" name="featured">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('featured') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                </div>
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Añadir</button>
                </div> --}}
            </div>
            <div class="wg-box">
                <div class="body-title mb-10">Tipo de Producto</div>
                <div class="select mb-10">
                    <select id="productType" name="product_type">
                        <option value="single">Producto Único</option>
                        <option value="variant">Producto con Variantes</option>
                    </select>
                </div>

                <div id="singleProductSection" class="product-section">
                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Precio<span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Precio normal" name="regular_price" tabindex="0" value="{{ old('regular_price') }}">
                        </fieldset>
                        @error('regular_price') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Precio Descuento</div>
                            <input class="mb-10" type="text" placeholder="Precio en Oferta" name="sale_price" tabindex="0" value="{{ old('sale_price') }}">
                        </fieldset>
                        @error('sale_price') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">¿Activar Oferta?</div>
                            <label class="switch">
                                <input type="checkbox" name="on_sale" value="1">
                                <span class="slider round"></span>
                            </label>
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10"># para almacén<span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Cod. para almacén" name="sku" tabindex="0" value="{{ old('sku') }}">
                        </fieldset>
                        @error('sku') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Cantidad de Unidades <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="number" placeholder="Cantidad de Unidades" name="quantity" tabindex="0" value="{{ old('quantity') }}">
                        </fieldset>
                        @error('quantity') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select name="stock_status">
                                    <option value="instock">En Stock</option>
                                    <option value="outofstock">Fuera de Stock</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('stock_status') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Destacado (Featured)</div>
                            <div class="select mb-10">
                                <select name="featured">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('featured') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                    </div>
                </div>

                <div id="variantProductSection" class="product-section" style="display:none;">
                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Colores (separar por coma)</div>
                            <input type="text" id="colorsInput" placeholder="Ej: Rojo, Azul, Negro">
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Tallas (separar por coma)</div>
                            <input type="text" id="sizesInput" placeholder="Ej: S, M, L, XL">
                        </fieldset>
                        <button type="button" id="generateVariantsBtn" class="tf-button w-full">Generar Variantes</button>
                    </div>
                    <div id="variantsTableContainer" class="mt-20">
                        </div>
                </div>

                <div class="cols gap10 mt-20">
                    <button class="tf-button w-full" type="submit">Añadir Producto</button>
                </div>
            </div>
        </form>
        <!-- /form-add-product -->
    </div>
    <!-- /main-content-wrap -->
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
                // $("#input[name='name']").on("change",function(){
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
        const productTypeSelect = document.getElementById('productType');
        const singleProductSection = document.getElementById('singleProductSection');
        const variantProductSection = document.getElementById('variantProductSection');
        const generateVariantsBtn = document.getElementById('generateVariantsBtn');
        const colorsInput = document.getElementById('colorsInput');
        const sizesInput = document.getElementById('sizesInput');
        const variantsTableContainer = document.getElementById('variantsTableContainer');

        // Función para manejar la visibilidad de las secciones
        function toggleProductSections() {
            if (productTypeSelect.value === 'single') {
                singleProductSection.style.display = 'block';
                variantProductSection.style.display = 'none';
            } else {
                singleProductSection.style.display = 'none';
                variantProductSection.style.display = 'block';
            }
        }
        
        // Ejecutar al cargar y al cambiar
        toggleProductSections();
        productTypeSelect.addEventListener('change', toggleProductSections);

        // Función para generar la tabla de variantes
        generateVariantsBtn.addEventListener('click', function() {
            const colors = colorsInput.value.split(',').map(c => c.trim()).filter(c => c);
            const sizes = sizesInput.value.split(',').map(s => s.trim()).filter(s => s);
            
            variantsTableContainer.innerHTML = '';
            
            if (colors.length === 0 && sizes.length === 0) {
                return;
            }

            let variantIndex = 0;
            let tableHtml = `
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Variante</th>
                                <th>Precio</th>
                                <th>Precio Desc.</th>
                                <th>Activar Desc.</th>
                                <th>Cantidad</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            if (colors.length > 0 && sizes.length > 0) {
                colors.forEach(color => {
                    sizes.forEach(size => {
                        tableHtml += createVariantRow(color, size, variantIndex);
                        variantIndex++;
                    });
                });
            } else if (colors.length > 0) {
                colors.forEach(color => {
                    tableHtml += createVariantRow(color, null, variantIndex);
                    variantIndex++;
                });
            } else if (sizes.length > 0) {
                sizes.forEach(size => {
                    tableHtml += createVariantRow(null, size, variantIndex);
                    variantIndex++;
                });
            }

            tableHtml += `</tbody></table></div>`;
            variantsTableContainer.innerHTML = tableHtml;
        });

        function createVariantRow(color, size, index) {
            const variantName = (color ? `Color: ${color}` : '') + (size ? ` Talla: ${size}` : '');
            const skuSuffix = (index + 1).toString().padStart(3, '0');
            const skuInput = `<input type="hidden" name="variants[${index}][sku]" value="001-${skuSuffix}">`;

            return `
                <tr>
                    <td>
                        <span class="variant-name">${variantName}</span>
                        <input type="hidden" name="variants[${index}][color]" value="${color || ''}">
                        <input type="hidden" name="variants[${index}][size]" value="${size || ''}">
                        ${skuInput}
                    </td>
                    <td><input type="number" step="0.01" name="variants[${index}][regular_price]" class="form-control" required></td>
                    <td><input type="number" step="0.01" name="variants[${index}][sale_price]" class="form-control"></td>
                    <td>
                        <label class="switch"><input type="checkbox" name="variants[${index}][on_sale]" value="1"><span class="slider round"></span></label>
                    </td>
                    <td><input type="number" name="variants[${index}][quantity]" class="form-control" required></td>
                    <td>
                        <select name="variants[${index}][stock_status]" class="form-control">
                            <option value="instock">En Stock</option>
                            <option value="outofstock">Fuera de Stock</option>
                        </select>
                    </td>
                </tr>
            `;
        }

        // Lógica de carga de imágenes (la que ya tenías)
        $("#myFile").on("change", function () {
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });

        $("#gFile").on("change", function () {
            const gphotos = this.files;
            $("#galUpload").find('.gitems').remove(); // Limpiar previas
            $.each(gphotos, function (key, val) {
                $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}"></div>`);
            });
        });
    });
</script>
@endpush