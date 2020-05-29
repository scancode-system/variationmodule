<?php

namespace Modules\Variation\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Product\Entities\Product;
use Modules\Variation\Repositories\VariationMinRepository;
use Exception;


class CheckItemsValidationMinListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $items = $event->items();
        foreach ($items as $item) {
            $this->checkItem($item, $items);
        }
    }




    private function checkItem($item, $items){

        $product = Product::find($item['product_id']); // depois passar para chamar por repositorio
        $items = $items; //ItemRepository::family($item); 


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
                    $product_family =  Product::find($item_family['product_id']);

                    if($product_family->$reference){
                        if($product_family->$reference->$field == $variation_min->value){
                            $variation_min->min_qty -= $item_family['qty'];               
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
            throw new Exception('O Item '. $product->description.' de código #'.$product->id.' não possui a quantidade mínima de variações configuradas pelo sistema.');
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
