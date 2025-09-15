<?php

namespace App\Http\Controllers\Admin;
use Intervention\Image\Laravel\Facades\Image;
use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function products()
    {
        $products = Product::orderBy('id', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function addProduct()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-add', compact('categories', 'brands'));
    }

    public function storeProduct(Request $request)
    {
        // 1. Validar los campos generales del producto
        $validationRules = [
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'featured' => 'required|boolean',
            'product_type' => ['required', Rule::in(['single', 'variant'])],
        ];

        // 2. Agregar reglas de validación específicas según el tipo de producto
        if ($request->input('product_type') === 'single') {
            $validationRules = array_merge($validationRules, [
                'regular_price' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|lt:regular_price|min:0',
                'sku' => 'required|string|unique:product_variants,sku',
                'quantity' => 'required|integer|min:0',
                'stock_status' => ['required', Rule::in(['instock', 'outofstock'])],
            ]);
        } else { // 'variant'
            $validationRules = array_merge($validationRules, [
                'variants' => 'required|array|min:1',
                'variants.*.sku' => 'required|string|unique:product_variants,sku',
                'variants.*.regular_price' => 'required|numeric|min:0',
                'variants.*.sale_price' => 'nullable|numeric|lt:variants.*.regular_price|min:0',
                'variants.*.quantity' => 'required|integer|min:0',
                'variants.*.stock_status' => ['required', Rule::in(['instock', 'outofstock'])],
            ]);
        }

        $request->validate($validationRules);

        // 3. Procesar imágenes y crear el producto principal.
        $current_timestamp = Carbon::now()->timestamp;
        $imageName = null;
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
        }

        $gallery_arr = [];
        if($request->hasFile('images')) {
            $counter = 1;
            foreach($request->file('images') as $file) {
                $gextension = $file->getClientOriginalExtension();
                $gfileName = $current_timestamp . "-" . $counter . "." . $gextension;
                $this->GenerateProductThumbnailImage($file, $gfileName);
                $gallery_arr[] = $gfileName;
                $counter++;
            }
        }
        
        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'image' => $imageName,
            'images' => implode(",", $gallery_arr),
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'featured' => $request->boolean('featured'),
        ]);

        // 4. Crear las variantes del producto según el tipo
        if ($request->input('product_type') === 'single') {
            ProductVariant::create([
            'product_id' => $product->id, // Usa el ID del producto que acabas de crear
            'sku' => $request->sku,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price ?? null,
            'on_sale' => $request->boolean('on_sale'),
            'quantity' => $request->quantity,
            'stock_status' => $request->stock_status,
            'color' => null, // Dejar nulo
            'size' => null,  // Dejar nulo
            ]);
        } else {
            foreach ($request->input('variants') as $variantData) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => $variantData['sku'],
                    'regular_price' => $variantData['regular_price'],
                    'sale_price' => $variantData['sale_price'] ?? null,
                    'on_sale' => $variantData['on_sale'] ?? false, // Usar 'false' en lugar de 'on'
                    'quantity' => $variantData['quantity'],
                    'stock_status' => $variantData['stock_status'],
                    'color' => $variantData['color'] ?? null,
                    'size' => $variantData['size'] ?? null,
                ]);
            }
        }
        
        return redirect()->route('admin.products')->with('status', 'Producto creado correctamente.');
    }

    public function editProduct($id)
    {
        $product = Product::find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-edit', compact('product', 'categories', 'brands'));
    }


    // UPDATE PRODUCT --- IGNORE --- FUNCIONABA CODIGO PARA SIN VARIANTES
    // public function updateProduct(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'slug' => 'required|unique:products,slug,'.$request->id,
    //         'short_description' => 'required',
    //         'description' => 'required',
    //         'regular_price' => 'required',
    //         'sale_price' => 'nullable',
    //         'sku' => 'required',
    //         'stock_status' => 'required',
    //         'featured' => 'required',
    //         'quantity' => 'required',
    //         'image' => 'mimes:png,jpg,jpeg|max:2048', 
    //         'category_id' => 'required',
    //         'brand_id' => 'required'
    //     ]);
    //     $product = Product::find($request->id);
    //     $product->name = $request->name;
    //     $product->slug = Str::slug($request->name);
    //     $product->short_description = $request->short_description;
    //     $product->description = $request->description;
    //     $product->regular_price = $request->regular_price;
    //     $product->sale_price = $request->sale_price;
    //     $product->on_sale = $request->input('on_sale');
    //     $product->sku = $request->sku;
    //     $product->stock_status = $request->stock_status;
    //     $product->featured = $request->featured;
    //     $product->quantity = $request->quantity;
    //     $product->category_id = $request->category_id;
    //     $product->brand_id = $request->brand_id;
    //     $current_timestamp = Carbon::now()->timestamp;
    //     if($request->hasFile('image'))
    //     {
    //         if(File::exists(public_path('uploads/products').'/'. $product->image)){
    //             File::delete(public_path('uploads/products').'/'. $product->image);
    //         };
    //         if(File::exists(public_path('uploads/products/thumbnails').'/'. $product->image)){
    //             File::delete(public_path('uploads/products/thumbnails').'/'. $product->image);
    //         };
    //         $image = $request->file('image');
    //         $imageName=$current_timestamp . '.' . $image->extension();
    //         $this->GenerateProductThumbnailImage($image,$imageName);
    //         $product->image = $imageName;
    //     }
    //     $gallery_arr = array();
    //     $gallery_images = "";
    //     $counter = 1;
    //     if($request->hasFile('images')){
    //         foreach(explode(',',$product->images) as $ofile)
    //         {
    //             if(File::exists(public_path('uploads/products').'/'. $ofile)){
    //                 File::delete(public_path('uploads/products').'/'. $ofile);
    //             };
    //             if(File::exists(public_path('uploads/products/thumbnails').'/'. $ofile)){
    //                 File::delete(public_path('uploads/products/thumbnails').'/'. $ofile);
    //             };
    //         }
    //         $allowedFileExtension = ['jpg','png','jpeg'];
    //         $files = $request->file('images');
    //         foreach($files as $file){
    //             $gextension = $file->getClientOriginalExtension();
    //             $gcheck = in_array($gextension, $allowedFileExtension);
    //             if($gcheck){
    //                 $gfileName = $current_timestamp . "-" . $counter . ".". $gextension;
    //                 $this->GenerateProductThumbnailImage($file,$gfileName);
    //                 array_push($gallery_arr, $gfileName);
    //                 $counter = $counter + 1; 
    //             }
    //         }
    //         $gallery_images = implode(",", $gallery_arr);
    //     }
    //     $product->images = $gallery_images;
    //     $product->save();
    //     return redirect()->route("admin.products")->with("status","updated");
        
    // }

    // UPDATE PRODUCT --- IGNORE --- 

    // public function updateProduct(Request $request)
    // {
    //     // 1. Validar los datos del producto principal
    //     $request->validate([
    //         'name' => 'required',
    //         'slug' => 'required|unique:products,slug,' . $request->id,
    //         'short_description' => 'required',
    //         'description' => 'required',
    //         'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
    //         'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048',
    //         'category_id' => 'required|exists:categories,id',
    //         'brand_id' => 'required|exists:brands,id',
    //         'featured' => 'required|boolean',
    //     ]);

    //     // 2. Obtener y actualizar el producto principal
    //     $product = Product::find($request->id);

    //     // Lógica de manejo de imágenes (tu código está bien, lo mantengo)
    //     $current_timestamp = Carbon::now()->timestamp;
    //     if ($request->hasFile('image')) {
    //         if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
    //             File::delete(public_path('uploads/products') . '/' . $product->image);
    //         };
    //         if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
    //             File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
    //         };
    //         $image = $request->file('image');
    //         $imageName = $current_timestamp . '.' . $image->extension();
    //         $this->GenerateProductThumbnailImage($image, $imageName);
    //         $product->image = $imageName;
    //     }
    //     $gallery_arr = array();
    //     $gallery_images = "";
    //     $counter = 1;
    //     if ($request->hasFile('images')) {
    //         foreach (explode(',', $product->images) as $ofile) {
    //             if (File::exists(public_path('uploads/products') . '/' . $ofile)) {
    //                 File::delete(public_path('uploads/products') . '/' . $ofile);
    //             };
    //             if (File::exists(public_path('uploads/products/thumbnails') . '/' . $ofile)) {
    //                 File::delete(public_path('uploads/products/thumbnails') . '/' . $ofile);
    //             };
    //         }
    //         $allowedFileExtension = ['jpg', 'png', 'jpeg'];
    //         $files = $request->file('images');
    //         foreach ($files as $file) {
    //             $gextension = $file->getClientOriginalExtension();
    //             $gcheck = in_array($gextension, $allowedFileExtension);
    //             if ($gcheck) {
    //                 $gfileName = $current_timestamp . "-" . $counter . "." . $gextension;
    //                 $this->GenerateProductThumbnailImage($file, $gfileName);
    //                 array_push($gallery_arr, $gfileName);
    //                 $counter = $counter + 1;
    //             }
    //         }
    //         $gallery_images = implode(",", $gallery_arr);
    //     }
    //     $product->images = $gallery_images;

    //     $product->name = $request->name;
    //     $product->slug = Str::slug($request->name);
    //     $product->short_description = $request->short_description;
    //     $product->description = $request->description;
    //     $product->category_id = $request->category_id;
    //     $product->brand_id = $request->brand_id;
    //     $product->featured = $request->featured;

    //     $product->save();

    //     // 3. Sincronizar las variantes
    //     $submittedVariantsIds = collect($request->input('variants', []))->pluck('id')->filter()->toArray();

    //     // Eliminar variantes que no se enviaron en el formulario
    //     $product->variants()->whereNotIn('id', $submittedVariantsIds)->delete();

    //     // Actualizar o crear variantes
    //     foreach ($request->input('variants', []) as $variantData) {
    //         $variantId = $variantData['id'] ?? null;
            
    //         // Validar el SKU dinámicamente
    //         $validator = Validator::make($variantData, [
    //             'sku' => [
    //                 'required',
    //                 'string',
    //                 Rule::unique('product_variants')->ignore($variantId),
    //             ],
    //             'regular_price' => 'required|numeric|min:0',
    //             'sale_price' => 'nullable|numeric|lt:regular_price|min:0',
    //             'quantity' => 'required|integer|min:0',
    //             'stock_status' => ['required', Rule::in(['instock', 'outofstock'])],
    //         ]);
            
    //         // Si la validación falla, redirige con errores
    //         if ($validator->fails()) {
    //             return redirect()->back()->withErrors($validator)->withInput();
    //         }

    //         if ($variantId) {
    //             // Actualizar una variante existente
    //             $variant = ProductVariant::find($variantId);
    //             $variant->update([
    //                 'sku' => $variantData['sku'],
    //                 'regular_price' => $variantData['regular_price'],
    //                 'sale_price' => $variantData['sale_price'] ?? null,
    //                 'on_sale' => isset($variantData['on_sale']) && $variantData['on_sale'] == 'on',
    //                 'quantity' => $variantData['quantity'],
    //                 'stock_status' => $variantData['stock_status'],
    //                 'color' => $variantData['color'] ?? null,
    //                 'size' => $variantData['size'] ?? null,
    //             ]);
    //         } else {
    //             // Crear una nueva variante
    //             ProductVariant::create([
    //                 'product_id' => $product->id,
    //                 'sku' => $variantData['sku'],
    //                 'regular_price' => $variantData['regular_price'],
    //                 'sale_price' => $variantData['sale_price'] ?? null,
    //                 'on_sale' => isset($variantData['on_sale']) && $variantData['on_sale'] == 'on',
    //                 'quantity' => $variantData['quantity'],
    //                 'stock_status' => $variantData['stock_status'],
    //                 'color' => $variantData['color'] ?? null,
    //                 'size' => $variantData['size'] ?? null,
    //             ]);
    //         }
    //     }

    //     return redirect()->route("admin.products")->with("status", "Producto actualizado correctamente.");
    // }


    
    // SE ESTYA TRATANDO DE ACTUALIZAR PRODUCTOS SIN VARIANTES



public function updateProduct(Request $request)
    {
    $product = Product::findOrFail($request->id);
    if ($product->variants->count() >= 2) {
        return $this->updateProductWithVariants($request);
    }else if ($product->variants->count() == 1) {
        return $this->updateSingleProduct($request);
    }
    }

    

    /**
     * Actualiza un producto con una sola variante.
     */
protected function updateSingleProduct(Request $request)
{
    // Validar producto (campos principales)
    $request->validate([
        'id' => 'required|exists:products,id',
        'name' => 'required',
        'slug' => 'required|unique:products,slug,' . $request->id,
        'short_description' => 'required',
        'description' => 'required',
        'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'required|exists:brands,id',
        'featured' => 'required|boolean',
    ]);

    // Actualizar producto
    $product = Product::findOrFail($request->id);
    $this->updateProductImages($request, $product);

    $product->name = $request->name;
    $product->slug = Str::slug($request->name);
    $product->short_description = $request->short_description;
    $product->description = $request->description;
    $product->category_id = $request->category_id;
    $product->brand_id = $request->brand_id;
    $product->featured = $request->featured;
    
    $product->save();

    $variantData = $request->input('variants',[]);
    $variantId = $variantData['id'] ?? null;
            if ($variantId) {
                    // Actualizar una variante existente
                    $variant = ProductVariant::find($variantId);
                    if ($variant) {
                        $variant->update([
                            'sku' => $variantData['sku'],
                            'regular_price' => $variantData['regular_price'],
                            'sale_price' => $variantData['sale_price'] ?? null,
                            'on_sale' => isset($variantData['on_sale']) && $variantData['on_sale'] == 'on',
                            'quantity' => $variantData['quantity'],
                            'stock_status' => $variantData['stock_status'],
                            'color' => $variantData['color'] ?? null,
                            'size' => $variantData['size'] ?? null,
                        ]);
                    } else {
                        return redirect()->route("admin.products")->with("status", "Fallo linea 429");
                    }
                } else {
                    return redirect()->route("admin.products")->with("status", "fallo linea 432");
            }

    return redirect()->route("admin.products")->with("status", "Producto único actualizado correctamente.");
}

    

    /**
     * Actualiza un producto con múltiples variantes.
     * Esta es la función que proporcionaste, con una pequeña mejora.
     */
    protected function updateProductWithVariants(Request $request)
    {
        // 1. Validar los datos del producto principal
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $request->id,
            'short_description' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'featured' => 'required|boolean',
        ]);
    
        // 2. Obtener y actualizar el producto principal
        $product = Product::find($request->id);
        $this->updateProductImages($request, $product);

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->featured = $request->featured;

        $product->save();

        // 3. Sincronizar las variantes
        $submittedVariantsIds = collect($request->input('variants', []))->pluck('id')->filter()->toArray();

        // Eliminar variantes que no se enviaron en el formulario
        $product->variants()->whereNotIn('id', $submittedVariantsIds)->delete();

        // Actualizar o crear variantes
        foreach ($request->input('variants', []) as $variantData) {
            $variantId = $variantData['id'] ?? null;
            
            // Validar el SKU dinámicamente
            $validator = Validator::make($variantData, [
                'sku' => [
                    'required',
                    'string',
                    Rule::unique('product_variants')->ignore($variantId),
                ],
                'regular_price' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|lt:regular_price|min:0',
                'quantity' => 'required|integer|min:0',
                'stock_status' => ['required', Rule::in(['instock', 'outofstock'])],
            ]);
            
            // Si la validación falla, redirige con errores
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($variantId) {
                // Actualizar una variante existente
                $variant = ProductVariant::find($variantId);
                
                // Verificación para evitar el error 'Call to a member function update() on null'
                if ($variant) {
                    $variant->update([
                        'sku' => $variantData['sku'],
                        'regular_price' => $variantData['regular_price'],
                        'sale_price' => $variantData['sale_price'] ?? null,
                        'on_sale' => isset($variantData['on_sale']) && $variantData['on_sale'] == 'on',
                        'quantity' => $variantData['quantity'],
                        'stock_status' => $variantData['stock_status'],
                        'color' => $variantData['color'] ?? null,
                        'size' => $variantData['size'] ?? null,
                    ]);
                } else {
                    // Si la variante no existe (fue borrada), la creamos de nuevo
                    $product->variants()->create($validator->validated());
                }
            } else {
                // Crear una nueva variante
                $product->variants()->create($validator->validated());
            }
        }
    
        return redirect()->route("admin.products")->with("status", "Producto actualizado correctamente.");
    }
    
    /**
     * Lógica para manejar la subida y eliminación de imágenes.
     * Separada para evitar repetición de código.
     */
    protected function updateProductImages(Request $request, Product $product)
    {
        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path('uploads/products') . '/' . $product->image)) {
                File::delete(public_path('uploads/products') . '/' . $product->image);
                File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
            }
            $imageName = $current_timestamp . '.' . $request->file('image')->extension();
            $this->GenerateProductThumbnailImage($request->file('image'), $imageName);
            $product->image = $imageName;
        }

        if ($request->hasFile('images')) {
            if ($product->images) {
                foreach (explode(',', $product->images) as $ofile) {
                    if (!empty(trim($ofile)) && File::exists(public_path('uploads/products') . '/' . trim($ofile))) {
                        File::delete(public_path('uploads/products') . '/' . trim($ofile));
                        File::delete(public_path('uploads/products/thumbnails') . '/' . trim($ofile));
                    }
                }
            }
            $gallery_arr = [];
            $counter = 1;
            foreach ($request->file('images') as $file) {
                $gfileName = $current_timestamp . "-" . $counter . "." . $file->getClientOriginalExtension();
                $this->GenerateProductThumbnailImage($file, $gfileName);
                array_push($gallery_arr, $gfileName);
                $counter++;
            }
            $product->images = implode(",", $gallery_arr);
        }
    }

    public function GenerateProductThumbnailImage($image, $imageName)
    {
        $destinationPathThumbnail = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');
        $img = Image::read($image->path());
        $img->cover(540,689,'top');
        $img->resize(540,689, function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'. $imageName);

        $img->resize(104,104, function($constraint){
        $constraint->aspectRatio();
        })->save($destinationPathThumbnail.'/'. $imageName);
    }
    public function deleteProduct($id){
        $product = product::find($id);
        if(file::exists(public_path('uploads/products').'/'.$product->image))
        {
            File::delete(public_path('uploads/products') .'/'.$product->image);
        }
        if(file::exists(public_path('uploads/products/thumbnails').'/'.$product->image))
        {
            File::delete(public_path('uploads/products/thumbnails') .'/'.$product->image);
        }
        foreach(explode(',',$product->images) as $ofile)
        {
            if(File::exists(public_path('uploads/products').'/'. $ofile)){
                File::delete(public_path('uploads/products').'/'. $ofile);
            };
            if(File::exists(public_path('uploads/products/thumbnails').'/'. $ofile)){
                File::delete(public_path('uploads/products/thumbnails').'/'. $ofile);
            };
        }
        $product->delete();
        return redirect()->route('admin.products')->with('status','Se ha eliminado el producto');
    }
}