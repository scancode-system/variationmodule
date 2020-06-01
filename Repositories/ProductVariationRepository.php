<?php

namespace Modules\Variation\Repositories;

use Modules\Variation\Entities\ProductVariation;
use Modules\Product\Entities\Product;

class ProductVariationRepository
{

	// CREATE
	public static function createByProduct(Product $product)
	{
		return  ProductVariation::create(['product_id' => $product->id]);
	}

	public static function create($product_id)
	{
		return  ProductVariation::create(['product_id' => $product_id]);
	}


}
