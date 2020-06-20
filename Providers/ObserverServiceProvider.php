<?php

namespace Modules\Variation\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Product\Entities\Product;
use Modules\Variation\Observers\ProductObserver;

class ObserverServiceProvider extends ServiceProvider {

	public function boot() {
		Product::observe(ProductObserver::class);
	}

	public function register() {
        //
	}

}
