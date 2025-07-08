<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\file;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands',compact('brands'));

    }

    // Marcas CRUD
    public function addBrand()
    {
        return view('admin.brand-add');

    }
    public function brandStore(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'slug'=> 'required|unique:brands,slug',
            'image'=> 'mimes:png,jpg,jpeg|max:2048'
        ]);
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extension;
        $this->GenerateBrandAndThumbnailsImage($image,$file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status','brand se añadio exitosamente');
    }

    public function editBrand($id){
        $brand = Brand::find($id);
        return view('admin.brand-edit',compact('brand'));
    }
    public function brandUpdate(Request $request){
        $request->validate([
            'name'=> 'required',
            'slug'=> 'required|unique:brands,slug,'.$request->id,
            'image'=> 'mimes:png,jpg,jpeg|max:2048'
        ]);
        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if($request->hasFile('image')){
            if(file::exists(public_path('uploads/brands').'/'.$brand->image))
            {
                File::delete(public_path('uploads/brands') .'/'.$brand->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $this->GenerateBrandAndThumbnailsImage($image,$file_name);
            $brand->image = $file_name;
        }
        $brand->save();
        return redirect()->route('admin.brands')->with('status','la marca se edito exitosamente');
    }
    public function GenerateBrandAndThumbnailsImage($image, $imagename)
    {
        $desttinationPath = public_path('uploads/brands');
        $img = Image::read($image->path());
        $img->cover(124,124,'top');
        $img->resize(124,124, function($constraint){
            $constraint->aspectRatio();
        })->save($desttinationPath.'/'. $imagename);
    }
    public function brandDelete($id){
        $brand = Brand::find($id);
        if(file::exists(public_path('uploads/brands').'/'.$brand->image))
        {
            File::delete(public_path('uploads/brands') .'/'.$brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status','Se ha eliminado la marca');
    }
//  CATEGORY SECTION
    public function categories(){
        $categories = Category::orderBy('id','DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function categoryAdd(){
        return view('admin.category-add');
    }
    public function categoryStore(Request $request){
        $request->validate([
            'name'=> 'required',
            'slug'=> 'required|unique:categories,slug',
            'image'=> 'mimes:png,jpg,jpeg|max:2048'
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->slug = str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extension;
        $this->GenerateCategoryAndThumbnailsImage($image,$file_name);
        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status','category se añadio exitosamente');
    }

    public function GenerateCategoryAndThumbnailsImage($image, $imagename)
    {
        $desttinationPath = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img->cover(124,124,'top');
        $img->resize(124,124, function($constraint){
            $constraint->aspectRatio();
        })->save($desttinationPath.'/'. $imagename);
    }

    public function editCategory($id){
        $category = Category::find($id);
        return view('admin.category-edit',compact('category'));
    }
    public function categoryUpdate(Request $request){
        $request->validate([
            'name'=> 'required',
            'slug'=> 'required|unique:categories,slug,'.$request->id,
            'image'=> 'mimes:png,jpg,jpeg|max:2048'
        ]);
        $category = category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if($request->hasFile('image')){
            if(file::exists(public_path('uploads/categories').'/'.$category->image))
            {
                File::delete(public_path('uploads/categories') .'/'.$category->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $this->GenerateCategoryAndThumbnailsImage($image,$file_name);
            $category->image = $file_name;
        }
        $category->save();
        return redirect()->route('admin.categories')->with('status','la marca se edito exitosamente');
    }

    public function categoryDelete($id){
        $category = Category::find($id);
        if(file::exists(public_path('uploads/categories').'/'.$category->image))
        {
            File::delete(public_path('uploads/categories') .'/'.$category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status','Se ha eliminado la marca');
    }

    public function products(){
        $products = Product::orderBy('id','DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function productAdd()
    {
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get();
        return view('admin.product-add',compact('categories','brands'));

    }
    public function productStore(Request $request)
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

        $current_timestamp=Carbon::now()->timestamp;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName->$current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image,$imageName);
            $product->image = $imageName;

        }

        $gallery_arr = array();;
        $gallery_images = "";
        $counter = 1;

        if($request->hasFile("images")){
            $allowedFileExtension = ['jpg','png','jpeg'];
            $files = $request->file('images');
            foreach($files as $file){
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedFileExtension);
                if($gcheck){
                    $gfileName = $current_timestamp . "-" . $counter . ".". $gextension;
                    $this->GenerateProductThumbnailImage($gfileName,$imageName);
                    array_push($gallery_arr, $gfileName);
                    $counter = $counter + 1;
                    
                }
            }
            $gallery_images = implode(",", $gallery_arr);


        }
        $product->images = $gallery_images;
        $product->save();
        return redirect()->route('admin.products')->with('status','se anadio el producto');
    }

    // public function editproduct($id){
    //     $product = product::find($id);
    //     return view('admin.product-edit',compact('product'));
    // }
    // public function productUpdate(Request $request){
    //     $request->validate([
    //         'name'=> 'required',
    //         'slug'=> 'required|unique:products,slug,'.$request->id,
    //         'image'=> 'mimes:png,jpg,jpeg|max:2048'
    //     ]);
    //     $product = product::find($request->id);
    //     $product->name = $request->name;
    //     $product->slug = Str::slug($request->name);
    //     if($request->hasFile('image')){
    //         if(file::exists(public_path('uploads/products').'/'.$product->image))
    //         {
    //             File::delete(public_path('uploads/products') .'/'.$product->image);
    //         }
    //         $image = $request->file('image');
    //         $file_extension = $request->file('image')->extension();
    //         $file_name = Carbon::now()->timestamp.'.'.$file_extension;
    //         $this->GenerateProductThumbnailImage($image,$file_name);
    //         $product->image = $file_name;
    //     }
    //     $product->save();
    //     return redirect()->route('admin.products')->with('status','la marca se edito exitosamente');
    // }
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
    // public function productDelete($id){
    //     $product = product::find($id);
    //     if(file::exists(public_path('uploads/products').'/'.$product->image))
    //     {
    //         File::delete(public_path('uploads/products') .'/'.$product->image);
    //     }
    //     $product->delete();
    //     return redirect()->route('admin.products')->with('status','Se ha eliminado la marca');
    // }
}
