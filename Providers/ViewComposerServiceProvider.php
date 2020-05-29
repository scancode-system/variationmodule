<?php

namespace Modules\Variation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Modules\Variation\Http\ViewComposers\Loader\Products\EditComposer;


class ViewComposerServiceProvider extends ServiceProvider {

	public function boot() {
		View::composer('variation::loader.products.edit', EditComposer::class);
	}

	public function register() {
        //
	}

}
