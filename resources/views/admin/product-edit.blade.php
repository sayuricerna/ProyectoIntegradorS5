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
                    <div class="body-title mb-10">Nombre<span class="tf-color-1">*</span>
                    </div>
                    <input class="mb-10" type="text" placeholder="Nombre de producto"
                        name="name" tabindex="0" value="{{ $product->name }}" aria-required="true" required="">
                    <div class="text-tiny">Max 100 Caracteres<.</div>
                </fieldset>
                    @error('name') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enlace interno para tienda"
                        name="slug" tabindex="0" value="{{ $product->slug }}" aria-required="true" required="">
                    <div class="text-tiny">Max 100c</div>
                </fieldset>
                    @error('slug') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Categoría <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="category_id">
                                <option>Escoger categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"{{ $product->category_id == $category->id ? "selected":"" }}>{{$category->name}}</option>
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
                                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? "selected":"" }}>{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error('brand_id') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Descripción Visible<span
                            class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="short_description"
                        placeholder="Descripción corta del producto" tabindex="0" aria-required="true"
                        required="">{{ $product->short_description }}</textarea>
                    <div class="text-tiny">max 50c</div>
                </fieldset>
                @error('short_description') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror

                <fieldset class="description">
                    <div class="body-title mb-10">Descripción <span class="tf-color-1">*</span>
                    </div>
                    <textarea class="mb-10" name="description" placeholder="Descripción"
                        tabindex="0" aria-required="true" required="">{{ $product->description }}</textarea>
                    <div class="text-tiny">max 100c</div>
                </fieldset>
                @error('description') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Imagen Principal <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        @if ($product->image)
                        <div class="item" id="imgpreview" >
                            <img src="{{ asset('uploads/products') }}/{{ $product->image }}"
                                class="effect8" alt="">
                        </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Subir <span
                                        class="tf-color"> </span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror

                <fieldset>
                    <div class="body-title mb-10">Imagenes de Grid</div>
                    <div class="upload-image mb-16">
                        @if ($product->images)
                        @foreach (explode(',',$product->images) as $img )
                        <div class="item gitems">
                            <img src="{{ asset('uploads/products') }}/{{ trim($img) }}" alt="">
                        </div>     
                        @endforeach    
                         @endif                                       
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Subir<span
                                        class="tf-color"> </span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*"
                                    multiple="">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('images') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Precio <span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Precio normal"
                            name="regular_price" tabindex="0" value="{{ $product->regular_price }}" aria-required="true"
                            required="">
                    </fieldset>
                    @error('regular_price') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Precio Descuento <span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Precio en Oferta"
                            name="sale_price" tabindex="0" value="{{ $product->sale_price }}" aria-required="true"
                            required="">
                    </fieldset>
                    @error('sale_price') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                </div>


                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10"># para almacén <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Cod. para almacen" name="sku"
                            tabindex="0" value="{{ $product->sku }}" aria-required="true" required="">
                    </fieldset>
                    @error('sku') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Cantidad de Unidades <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Cantidad de Unidades"
                            name="quantity" tabindex="0" value="{{ $product->quantity }}" aria-required="true"
                            required="">
                    </fieldset>
                    @error('quantity') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock</div>
                        <div class="select mb-10">
                            <select class="" name="stock_status">
                                <option value="instock" {{ $product->stock_status == "instock" ? "selected":"" }}>En Stock</option>
                                <option value="outofstock" {{ $product->stock_status == "outofstock" ? "selected":"" }}>Fuera de Stock</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('stock_status') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Featured</div>
                        <div class="select mb-10">
                            <select class="" name="featured">
                                <option value="0" {{ $product->featured == "0" ? "selected":"" }}>No</option>
                                <option value="1" {{ $product->featured == "1" ? "selected":"" }}>Si</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('featured') <span class='alert alert-danger text-center'>{{$message}}</span> @enderror
                </div>
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Actualizar</button>
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
@endpush