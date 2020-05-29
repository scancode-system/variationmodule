<?php

namespace Modules\Variation\Observers;

use Modules\Order\Entities\Order;
use Modules\Order\Entities\Item;
use Modules\Order\Entities\Status;
use Modules\Variation\Repositories\VariationMinRepository;
use Modules\Order\Repositories\ItemRepository;
use Carbon\Carbon;
use Exception;

class OrderObserver
{

	public function updating(Order $order)
	{
		if($order->isDirty('status_id')){
			if($order->status_id == STATUS::COMPLETED){
				foreach ($order->items as $item) {
					$this->checkItem($item);
				}
			} 
		}
	}

	private function checkItem(Item $item){
		$product = $item->product;
		$items = ItemRepository::family($item); 


		$variation_mins = VariationMinRepository::loadBySku($product->sku);
		$rules = $variation_mins->groupBy(function($variation_min, $key){
			return $variation_min->group;
		});


		$fail =  true;
		$item_not_in_rule = true;
		foreach ($rules as $rule) {

			foreach ($rule as $variation_min) {
				$reference = $variation_min->variation->table;
				$field = $variation_min->variation->field;

				if($product->$reference){
					if($product->$reference->$field == $variation_min->value){
						$item_not_in_rule = false;
					}
				}				

				foreach ($items as $item_family) {
					$product_family = $item_family->product;

					if($product_family->$reference){
						if($product_family->$reference->$field == $variation_min->value){
							$variation_min->min_qty -= $item_family->qty;				
						}
					}
				}
			}

			//dd($rule);
			if($this->checkRule($rule)){
				$fail = false;
				break;
			}
		}

		if($fail && !$item_not_in_rule){
			throw new Exception('O Item '. $item->item_product->description.' de código #'.$item->product_id.' não possui a quantidade mínima de variações configuradas pelo sistema.');
		}
	}

	private function checkRule($rule){
		foreach ($rule as $variation_min) {
			if($variation_min->min_qty > 0){
				return false;
			}
		}
		return true;
	}

}
