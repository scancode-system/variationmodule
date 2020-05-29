<?php

namespace Modules\Variation\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Variation\Entities\VariationMin;
use Modules\Variation\Observers\VariationMinObserver;
use Modules\Order\Entities\Order;
use Modules\Variation\Observers\OrderObserver;

class ObserverServiceProvider extends ServiceProvider {

	public function boot() {
		VariationMin::observe(VariationMinObserver::class);
		Order::observe(OrderObserver::class);
	}

	public function register() {
        //
	}

}
