<?php

namespace Modules\Variation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

use Modules\Product\Entities\Product;
use Modules\Variation\Entities\ProductVariation;

use Modules\Variation\Entities\VariationMin;


class RelationshipServiceProvider extends ServiceProvider
{


    public function boot()
    {
        Product::addDynamicRelation('product_variation', function (Product $product) {
            return $product->hasOne(ProductVariation::class);
        });

        Product::addDynamicRelation('variation_mins', function (Product $product) {
            return $product->hasMany(VariationMin::class, 'sku', 'sku');
        });

    }



    public function register()
    {

    }

}
