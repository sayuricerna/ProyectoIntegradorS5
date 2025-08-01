<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query("size") ? $request->query("size") :12;
        $o_column = "";
        $o_order = "";
        $order = $request->query("order") ? $request->query("order") : -1;
        $f_brands = $request->query("brands");
        $f_categories = $request->query("categories");
        // $min_price = $request->query("min") ? $request->query("min") : 1;
        // $max_price = $request->query("max") ? $request->query("max") : 500;
        switch ($order) {
            case 1:
                $o_column = "regular_price";
                $o_order = "asc";
                break;
            case 2:
                $o_column = "regular_price";
                $o_order = "desc";
                break;
            default:
                $o_column = "id";
                $o_order = "desc";
        }
        $brands = Brand::orderBy("name","asc")->get();
        $categories = Category::orderBy("name","asc")->get();
        
        $products = Product::where(function($query)use($f_brands){
            $query->whereIn("brand_id", explode(",",$f_brands))->orWhereRaw("'".$f_brands."' = ''");
        })->where(function($query)use($f_categories){
            $query->whereIn("category_id", explode(",",$f_categories))->orWhereRaw("'".$f_categories."' = ''");
        })


        // ->where(function($query)use($min_price, $max_price){
        //     $query->whereBetween("regular_price", [$min_price, $max_price])
        //     ->orWhereBetween('sale_price', [$min_price, $max_price]);
        // })


        ->orderBy($o_column,$o_order)->paginate($size);
        return view("shop", compact("products", 'size','order','brands','f_brands','categories','f_categories'));
    }
    public function productDetails($product_slug){
        $product = Product::where("slug", $product_slug)->first();
        $products = Product::where("slug",'<>', $product_slug)->get()->take(8);
        return view("details", compact("product","products"));
    }
}
