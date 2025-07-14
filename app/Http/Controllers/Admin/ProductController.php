<?php

namespace App\Http\Controllers\Admin;
use Intervention\Image\Laravel\Facades\Image;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
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
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'nullable',
            'sku' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required'
        ]);

        $product = new Product();
        $this->saveProductData($product, $request);
        
        return redirect()->route('admin.products')->with('status', 'Producto añadido exitosamente');
    }

    public function editProduct($id)
    {
        $product = Product::find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-edit', compact('product', 'categories', 'brands'));
    }

    public function updateProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,'.$request->id,
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'nullable',
            'sku' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required'
        ]);

        $product = Product::find($request->id);
        $this->saveProductData($product, $request);
        
        return redirect()->route('admin.products')->with('status', 'Producto actualizado exitosamente');
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        
        // Eliminar imagen principal
        if (File::exists(public_path('uploads/products/').$product->image)) {
            File::delete([
                public_path('uploads/products/').$product->image,
                public_path('uploads/products/thumbnails/').$product->image
            ]);
        }
        
        // Eliminar imágenes de la galería
        if ($product->images) {
            foreach (explode(',', $product->images) as $image) {
                if (File::exists(public_path('uploads/products/').$image)) {
                    File::delete([
                        public_path('uploads/products/').$image,
                        public_path('uploads/products/thumbnails/').$image
                    ]);
                }
            }
        }
        
        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Producto eliminado exitosamente');
    }

    private function saveProductData($product, $request)
    {
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->sku = $request->sku;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        // Procesar imagen principal
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($product->image) {
                if (File::exists(public_path('uploads/products/').$product->image)) {
                    File::delete([
                        public_path('uploads/products/').$product->image,
                        public_path('uploads/products/thumbnails/').$product->image
                    ]);
                }
            }
            
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->generateProductThumbnails($image, $imageName);
            $product->image = $imageName;
        }

        // Procesar imágenes de galería
        if ($request->hasFile('images')) {
            $gallery = [];
            $counter = 1;
            
            // Eliminar imágenes anteriores si existen
            if ($product->images) {
                foreach (explode(',', $product->images) as $oldImage) {
                    if (File::exists(public_path('uploads/products/').$oldImage)) {
                        File::delete([
                            public_path('uploads/products/').$oldImage,
                            public_path('uploads/products/thumbnails/').$oldImage
                        ]);
                    }
                }
            }
            
            foreach ($request->file('images') as $file) {
                $extension = $file->extension();
                $fileName = $current_timestamp . '-' . $counter . '.' . $extension;
                $this->generateProductThumbnails($file, $fileName);
                $gallery[] = $fileName;
                $counter++;
            }
            
            $product->images = implode(',', $gallery);
        }

        $product->save();
    }

    private function generateProductThumbnails($image, $imageName)
    {
        $destinationPath = public_path('uploads/products');
        $thumbnailPath = public_path('uploads/products/thumbnails');
        $img = Image::make($image->path());
        
        // Imagen principal
        $img->fit(540, 689, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
        
        // Miniatura
        $img->fit(104, 104, function ($constraint) {
            $constraint->aspectRatio();
        })->save($thumbnailPath.'/'.$imageName);
    }
}