<?php

namespace Modules\Variation\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Variation\Services\VariationService;
use Modules\Product\Entities\Product;

class ProductVariation extends Model
{

	protected $fillable = ['product_id'];
	protected $appends = ['all', 'available'];


    // relations
	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	
	// attributes
	public function getAllAttribute()
	{

		$variation_service = new VariationService($this);
		return $variation_service->all();
	}


	public function getAvailableAttribute()
	{
		$variation_service = new VariationService($this);
		return $variation_service->available();
	}

}
