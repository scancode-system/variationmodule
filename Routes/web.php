<?php


Route::prefix('variation_mins')->middleware('auth')->group(function() {
	Route::post('{product}', 'VariationMinController@store')->name('variation_mins.store');

	Route::delete('{variation_min}', 'VariationMinController@destroy')->name('variation_mins.destroy');

});
