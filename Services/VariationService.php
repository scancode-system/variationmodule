<?php

namespace Modules\Variation\Services;

use Modules\Variation\Entities\ProductVariation;
use Modules\Product\Entities\Product;
use Modules\Variation\Repositories\VariationRepository;

class VariationService {

	private $product;
	private $products_family;

	private $variations;

	public function __construct(ProductVariation $product_variation) 
	{
		$this->product = Product::find($product_variation->product_id);
		$this->products_family = $this->product->family;
		$this->variations = VariationRepository::load();
	}

	private function buildAll()
	{
		$all = collect([]);

		foreach ($this->variations as $variation) {
			$values = collect([]);

			$all[$variation->alias] = [];

			foreach ($this->products_family as $product) {
				$variation_table = $variation->table;
				$variation_field = $variation->field;
				if($product->$variation_table){
					$values->push($product->$variation_table->$variation_field);
				}
			}

			$values = $values->unique()->values();
			$all->put($variation->alias, collect(['variation' => $variation->alias,'table' => $variation->table, 'column' => $variation->field, 'items' => $values]));			

		}
		return $all;
	}

	public function all()
	{		
return $this->buildAll()->values();
	}

	public function available()
	{
		$all = $this->buildAll();

		foreach ($this->variations as $variation) {
			$variations_ = $this->removeCurrentVariation($this->variations, $variation);

			$variation_table = $variation->table;

			if($this->product->$variation_table){
				$id = $this->product->$variation_table->id;
			} else {
				$id = $this->product->$variation_table;
			}
			
			
			$products = $this->filterByVariation($id, $variation);

			foreach ($variations_ as $variation_) {
				$values_available = collect([]);
				foreach ($products as $product) {
					$variation_table_ = $variation_->table;
					$variation_field_ = $variation_->field;
					if($product->$variation_table_){
						$values_available->push($product->$variation_table_->$variation_field_);
					}
				}


				$all[$variation_->alias]['items'] = $all[$variation_->alias]['items']->filter(function ($value) use($values_available) {
					foreach ($values_available as $value_available) {
						if($value == $value_available) {
							return true;
						}
					}
					return false;
				})->values();
			}
		}

		return $all->values();
	}


	private function removeCurrentVariation($variations, $variation_current)
	{
		return $variations->reject(function ($variation) use ($variation_current) {
			return $variation_current->id == $variation->id;
		});
	}

	private function filterByVariation($id, $variation)
	{
		return $this->products_family->filter(function ($product) use ($id, $variation) {
			$variation_table = $variation->table;

			if($product->$variation_table){
				return $product->$variation_table->id == $id;
			} else {
				return $product->$variation_table == $id; 
			}
			
		});
	}

}
