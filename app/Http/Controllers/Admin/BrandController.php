<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Intervention\Image\Laravel\Facades\Image;

class BrandController extends Controller
{
    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands',compact('brands'));
    }

    public function addBrand()
    {
          return view('admin.brand-add');
    }

    public function storeBrand(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'image'=> 'mimes:png,jpg,jpeg|max:2048'
        ]);
        $brand = new Brand();
        $brand->name = $request->name; 
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extension;
        $this->generateBrandThumbnail($image,$file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status','brand se añadio exitosamente');
    }

    public function editBrand($id)
    {
       $brand = Brand::find($id);
        return view('admin.brand-edit',compact('brand'));
    }

    public function updateBrand(Request $request)
    {
        $request->validate([
            'name'=> 'required',
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
            $this->generateBrandThumbnail($image,$file_name);
            $brand->image = $file_name;
        }
        $brand->save();
        return redirect()->route('admin.brands')->with('status','la marca se edito exitosamente');
    }

    public function deleteBrand($id)
    {
        $brand = Brand::find($id);
        
        if (File::exists(public_path('uploads/brands/').$brand->image)) {
            File::delete(public_path('uploads/brands/').$brand->image);
        }
        
        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'Marca eliminada exitosamente');
    }

    public function generateBrandThumbnail($image, $imagename)
    {
        $desttinationPath = public_path('uploads/brands');
        $img = Image::read($image->path());
        $img->cover(124,124,'top');
        $img->resize(124,124, function($constraint){
            $constraint->aspectRatio();
        })->save($desttinationPath.'/'. $imagename);
    }
}