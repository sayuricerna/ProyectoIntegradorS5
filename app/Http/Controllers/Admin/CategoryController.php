<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function addCategory()
    {
        return view('admin.category-add');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->generateCategoryThumbnail($image, $file_name);
            $category->image = $file_name;
        }

        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Categoría añadida exitosamente');
    }

    public function editCategory($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }

    public function updateCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/categories/').$category->image)) {
                File::delete(public_path('uploads/categories/').$category->image);
            }
            
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->generateCategoryThumbnail($image, $file_name);
            $category->image = $file_name;
        }

        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Categoría actualizada exitosamente');
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        
        if (File::exists(public_path('uploads/categories/').$category->image)) {
            File::delete(public_path('uploads/categories/').$category->image);
        }
        
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Categoría eliminada exitosamente');
    }

    private function generateCategoryThumbnail($image, $imageName)
    {
        $destinationPath = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img = $img->resize(124, 124)->cover(124, 124);
        $img->save($destinationPath.'/'.$imageName);
    }
}