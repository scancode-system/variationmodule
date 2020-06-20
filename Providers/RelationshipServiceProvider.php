<?php

namespace Modules\Variation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

use Modules\Product\Entities\Product;
use Modules\Variation\Entities\ProductVariation;


class RelationshipServiceProvider extends ServiceProvider
{


    public function boot()
    {
        Product::addDynamicRelation('product_variation', function (Product $product) {
            return $product->hasOne(ProductVariation::class);
        });

    }



    public function register()
    {

    }

}
