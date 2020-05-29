<?php

namespace Modules\Variation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Variation\Http\Requests\VariationMinRequest;
use Modules\Variation\Repositories\VariationMinRepository;
use Modules\Product\Entities\Product;
use Modules\Variation\Entities\VariationMin;

class VariationMinController extends Controller
{

	public function store(VariationMinRequest $request, Product $product)
	{
		VariationMinRepository::createBySku($product->sku, $request->all());
		return back()->with('success', 'Regra adicionada.');
	}

	public function destroy(Request $request, VariationMin $variation_min)
	{
		VariationMinRepository::destroy($variation_min);
		return back()->with('success', 'Regra(s) removidas.');
	}

}
