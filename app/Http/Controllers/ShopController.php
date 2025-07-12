<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query("size") ? $request->query("size") :12;

        $products = Product::orderBy("created_at","desc")->paginate($size);
        return view("shop", compact("products", 'size'));
    }
    public function productDetails($product_slug){
        $product = Product::where("slug", $product_slug)->first();
        $products = Product::where("slug",'<>', $product_slug)->get()->take(8);
        return view("details", compact("product","products"));
    }
}
