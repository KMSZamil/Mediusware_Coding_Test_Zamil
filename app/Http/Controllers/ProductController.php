<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
