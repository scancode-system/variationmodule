<?php

namespace Modules\Variation\Observers;

use Modules\Product\Entities\Product;
use Modules\Variation\Repositories\ProductVariationRepository;

class ProductObserver
{

	public function created(Product $product) {
		ProductVariationRepository::createByProduct($product);
	}	

}
