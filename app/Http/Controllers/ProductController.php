<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Variant;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use App\Models\ProductVariantPrice;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $products = ProductVariantPrice::with([
            'product_data', 'product_variant_one_data', 'product_variant_two_data', 'product_variant_three_data'
        ])->paginate(10);
        //return $products;
        $product_data =  $products->groupBy('product_id');
        //return $products;

        $variants = DB::select("SELECT distinct variant_id, variant, v.title
                        FROM product_variants pv
                        inner join variants v on pv.variant_id = v.id
                        ");
        $variants =  collect($variants)->groupBy('title');
        //return $variants;
        return view('products.index', compact('products', 'variants', 'product_data'));
    }

    public function product_filter()
    {
        $title = request()->title;
        $variant = request()->variant;
        $price_from = request()->price_from;
        $price_to = request()->price_to;
        $date = request()->date;

        $products = ProductVariantPrice::with([
            'product_data'
            => function ($query) use ($title, $date) {
                $query->orWhere('title', 'like %', $title . '%')->orWhere('created_at', $date);
            }, 'product_variant_one_data', 'product_variant_two_data', 'product_variant_three_data'
        ])
            ->whereBetween('price', [$price_from, $price_to])
            ->orWhere('product_variant_one', $variant)
            ->orWhere('product_variant_two', $variant)
            ->orWhere('product_variant_three', $variant)

            ->paginate(10);
        //return $products;
        $product_data =  $products->groupBy('product_id');
        //return $products;

        $variants = DB::select("SELECT distinct variant_id, variant, v.title
                        FROM product_variants pv
                        inner join variants v on pv.variant_id = v.id
                        ");
        $variants =  collect($variants)->groupBy('title');
        //return $variants;
        return view('products.index', compact('products', 'variants', 'product_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return $request->all();
        //return $request->product_variant_prices['tags'][0];
        $title = $request->title;
        $description = $request->description;
        $sku = $request->sku;

        $product = new product();
        $product->title = $title;
        $product->description = $description;
        $product->sku = $sku;
        $product->save();

        if (isset($request->product_image)) {
            for ($i = 0; $i < count($request->product_image); $i++) {
                $product_image = new ProductImage();
                $product_image->product_id = $product->id;
                $md5Name = md5_file($request->product_image[$i]->getRealPath()) . time();
                $mimeType = $request->product_image[$i]->guessExtension();
                $path = $request->product_image[$i]->storeAs('uploads/product', $md5Name . '.' . $mimeType, 'public');
                $product_image->file_path = $path;
                $product_image->save();
            }
        }

        if (isset($request->product_variant)) {
            for ($i = 0; $i < count($request->product_variant); $i++) {
                for ($j = 0; $j < count($request->product_variant[$i]['tags']); $j++) {
                    $product_variant = new ProductVariant();
                    $product_variant->product_id = $product->id;
                    $product_variant->variant = $request->product_variant[$i]['tags'][$j];
                    $product_variant->variant_id = $request->product_variant[$i]['option'];
                    $product_variant->save();
                }
            }
        }

        if (isset($request->product_variant_prices)) {
            for ($i = 0; $i < count($request->product_variant_prices); $i++) {
                $product_variant_price = new ProductVariantPrice();
                if ($i == 0) {
                    $product_variant_price->product_variant_one = $request->product_variant[$i]['option'];
                } else if ($i == 1) {
                    $product_variant_price->product_variant_two = $request->product_variant[$i]['option'];
                } else if ($i == 2) {
                     if(isset($request->product_variant[$i]['option'])) {
                        $product_variant_price->product_variant_three =  $request->product_variant[$i]['option'];
                     }
                }
                $product_variant_price->stock = $request->product_variant_prices[$i]['stock'];
                $product_variant_price->price = $request->product_variant_prices[$i]['price'];
                $product_variant_price->product_id = $product->id;
                $product_variant_price->save();
            }
        }

        $products = ProductVariantPrice::with([
            'product_data', 'product_variant_one_data', 'product_variant_two_data', 'product_variant_three_data'
        ])->paginate(10);
        //return $products;
        $product_data =  $products->groupBy('product_id');
        //return $products;

        $variants = DB::select("SELECT distinct variant_id, variant, v.title
                        FROM product_variants pv
                        inner join variants v on pv.variant_id = v.id
                        ");
        $variants =  collect($variants)->groupBy('title');
        //return $variants;
        return view('products.index', compact('products', 'variants', 'product_data'));
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
