<?php

namespace Modules\Variation\Repositories;

use Modules\Variation\Entities\Variation;

class VariationRepository
{


	// CREATE
	public static function create($data)
	{
		return Variation::create($data);
	}


	// LOADS
	public static function load()
	{
		return Variation::all();
	}

	// UPDATE
	public static function update(Variation $variation, $data)
	{
		$variation->update($data);
		return $variation;
	}	


	// DELETE
	public static function deleteByAlias($alias){
		Variation::where('alias', $alias)->first()->delete();
	}


}
