<?php

namespace Modules\Variation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;


use Modules\Product\Events\ProductLazyEagerLoadingEvent;
use Modules\Variation\Listeners\EagerLoadingProductVariationListener;

class EventServiceProvider extends ServiceProvider 
{

	public function boot() 
	{

	}

	public function register() 
	{
		Event::listen(ProductLazyEagerLoadingEvent::class, EagerLoadingProductVariationListener::class);
	}

}
