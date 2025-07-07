<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\file;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;
use App\Models\Category;
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

}
