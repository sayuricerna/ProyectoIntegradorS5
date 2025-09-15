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
        $o_column = "products.id";
        $o_order = "desc";
        $order = $request->query("order") ? $request->query("order") : -1;
        $f_brands = $request->query("brands");
        $f_categories = $request->query("categories");

        switch ($order) {
            case 1:
                $o_column = "min_price";
                $o_order = "asc";
                break;
            case 2:
                $o_column = "max_price";
                $o_order = "desc";
                break;
            default:
                $o_column = "products.id";
                $o_order = "desc";
        }

        $query = Product::leftJoin('product_variants as pv', 'products.id', '=', 'pv.product_id')
                        ->selectRaw('products.*, MIN(pv.regular_price) as min_price, MAX(pv.regular_price) as max_price')
                        ->where(function($q) use ($f_brands) {
                            $q->whereIn("products.brand_id", explode(",", $f_brands))->orWhereRaw("'" . $f_brands . "' = ''");
                        })
                        ->where(function($q) use ($f_categories) {
                            $q->whereIn("products.category_id", explode(",", $f_categories))->orWhereRaw("'" . $f_categories . "' = ''");
                        })
                        ->groupBy('products.id', 'products.name', 'products.slug', 'products.description', 'products.short_description', 'products.featured', 'products.image', 'products.images', 'products.brand_id', 'products.category_id', 'products.created_at', 'products.updated_at')
                        ->orderBy($o_column, $o_order);
        
        $products = $query->paginate($size);
        
        $brands = Brand::orderBy("name","asc")->get();
        $categories = Category::orderBy("name","asc")->get();

        return view("shop", compact("products", 'size', 'order', 'brands', 'f_brands', 'categories', 'f_categories'));
    }

public function productDetails($product_slug){
    // Asegúrate de cargar las variantes con el producto.
    $product = Product::with('variants')->where("slug", $product_slug)->firstOrFail();
    $products = Product::where("slug",'<>', $product_slug)->get()->take(8);
    return view("details", compact("product","products"));
}
    // funcionando versdion antes de variantes 
    // public function index(Request $request)
    // {
    //     $size = $request->query("size") ? $request->query("size") :12;
    //     $o_column = "";
    //     $o_order = "";
    //     $order = $request->query("order") ? $request->query("order") : -1;
    //     $f_brands = $request->query("brands");
    //     $f_categories = $request->query("categories");
    //     // $min_price = $request->query("min") ? $request->query("min") : 1;
    //     // $max_price = $request->query("max") ? $request->query("max") : 500;
    //     switch ($order) {
    //         case 1:
    //             $o_column = "regular_price";
    //             $o_order = "asc";
    //             break;
    //         case 2:
    //             $o_column = "regular_price";
    //             $o_order = "desc";
    //             break;
    //         default:
    //             $o_column = "id";
    //             $o_order = "desc";
    //     }
    //     $brands = Brand::orderBy("name","asc")->get();
    //     $categories = Category::orderBy("name","asc")->get();
        
    //     $products = Product::where(function($query)use($f_brands){
    //         $query->whereIn("brand_id", explode(",",$f_brands))->orWhereRaw("'".$f_brands."' = ''");
    //     })->where(function($query)use($f_categories){
    //         $query->whereIn("category_id", explode(",",$f_categories))->orWhereRaw("'".$f_categories."' = ''");
    //     })


    //     // ->where(function($query)use($min_price, $max_price){
    //     //     $query->whereBetween("regular_price", [$min_price, $max_price])
    //     //     ->orWhereBetween('sale_price', [$min_price, $max_price]);
    //     // })


    //     ->orderBy($o_column,$o_order)->paginate($size);
    //     return view("shop", compact("products", 'size','order','brands','f_brands','categories','f_categories'));
    // }
    // public function productDetails($product_slug){
    //     $product = Product::where("slug", $product_slug)->first();
    //     $products = Product::where("slug",'<>', $product_slug)->get()->take(8);
    //     return view("details", compact("product","products"));
    // }
}
