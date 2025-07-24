<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;


class HomeController extends Controller
{

    public function index()
    
    {
        $total_categories = Category::count();

        $categories = Category::orderBy('name')->get()->take($total_categories);
        $featured_products = Product::where('featured',1)->get()->take(8);
        return view('index',compact('categories','featured_products'));
    }
}
