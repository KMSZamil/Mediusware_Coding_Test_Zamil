<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class ProductVariantPrice extends Model
{
    use Compoships;

    public function product_data()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function product_variant_one_data()
    {
        return $this->hasOne(ProductVariant::class, ['id', 'product_id'], ['product_variant_one', 'product_id']);
    }
    public function product_variant_two_data()
    {
        return $this->hasOne(ProductVariant::class, ['id', 'product_id'], ['product_variant_two', 'product_id']);
    }
    public function product_variant_three_data()
    {
        return $this->hasOne(ProductVariant::class, ['id', 'product_id'], ['product_variant_three', 'product_id']);
    }
}
