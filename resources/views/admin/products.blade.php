@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Productos</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div> </a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Productos</div></li>
            </ul>
        </div>
        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Buscar" class="" name="name" tabindex="2" value="" aria-required="true" required="">
                        </fieldset>
                        <div class="button-submit"> <button class="" type="submit"><i class="icon-search"></i></button></div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}"><i class="icon-plus"></i>Añadir</a>
            </div>
            <div class="table-responsive">
                @if (Session::has('status'))
                <p class="alert alert-success">{{ Session::get('status')}}</p>
                @endif                                        
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Precio con descuento</th>
                            <th>código</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Destacado</th>
                            <th>Stock</th>
                            <th>Cantidad</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{ asset('uploads/products/thumbnails') }}/{{ $product->image }}" alt="{{ $product->name }}" class="image">
                                </div>
                                <div class="name">
                                    <a href="#" class="body-title-2">{{$product->name}}</a>
                                    <div class="text-tiny mt-3">{{$product->slug}}</div>
                                </div>
                            </td>
                            {{-- <td>{{$product->regular_price}}</td>
                            <td>{{$product->sale_price}}</td>
                            <td>{{$product->sku}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>{{$product->brand->name}}</td>
                            <td>{{$product->feature == 0 ? "No":"Si"}}</td>
                            <td>{{$product->stock_status}}</td>
                            <td>{{$product->quantity}}</td>
                            <td> --}}
                            @php
                                $firstVariant = $product->variants->first();
                                $isVariantProduct = $product->variants->count() > 1;

                                $regularPrices = $product->variants->pluck('regular_price');
                                $salePrices = $product->variants->pluck('sale_price');
                                $totalQuantity = $product->variants->sum('quantity');
                            @endphp

                            <td>
    @if($isVariantProduct)
        ${{ number_format($regularPrices->min(), 2) }} - ${{ number_format($regularPrices->max(), 2) }}
    @else
        @if($firstVariant)
            ${{ number_format($firstVariant->regular_price, 2) }}
        @else
            -
        @endif
    @endif
</td>
<td>
    @if($isVariantProduct)
        @if ($salePrices->filter()->isNotEmpty())
            ${{ number_format($salePrices->filter()->min(), 2) }} - ${{ number_format($salePrices->filter()->max(), 2) }}
        @else
            -
        @endif
    @else
        @if ($firstVariant && $firstVariant->sale_price)
            ${{ number_format($firstVariant->sale_price, 2) }}
        @else
            -
        @endif
    @endif
</td>
                            <td>{{ $firstVariant->sku ?? 'N/A' }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->brand->name }}</td>
                            <td>{{ $product->featured == 0 ? "No":"Si"}}</td>
                            <td>{{ $firstVariant->stock_status ?? 'N/A'}}</td>
                            <td>{{ $totalQuantity }}</td>
                            <td>
        
                                <div class="list-icon-function">
                                    <a href="#" target="_blank"><div class="item eye"><i class="icon-eye"></i></div></a>
                                    <a href="{{ route('admin.product.edit',['id'=>$product->id]) }}">
                                        <div class="item edit"><i class="icon-edit-3"></i></div>
                                    </a>
                                    <form action="{{ route('admin.product.delete',['id'=>$product->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="item text-danger delete"><i class="icon-trash-2"></i></div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">{{ $products->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(function(){
        $('.delete').on('click',function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Esta seguro de eliminar",
                text: "Una vez borrado no se podrá recuperar",
                type: "advertencia",
                buttons: ["No","Si"],
                confirmButtonColor: '#dc3545'
            }).then(function(result){
                if(result){
                    form.submit();
                }
            });
        });
    });
</script>
@endpush