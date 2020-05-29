<?php

namespace Modules\Variation\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Variation\Entities\Variation;
use Modules\Variation\Entities\VariationMin;

class VariationMin extends Model
{
	protected $fillable = ['sku', 'variation_id', 'value', 'min_qty', 'group'];


	public function variation()
	{
		return $this->belongsTo(Variation::class);
	}


	public function group_variation_mins()
	{
		return $this->hasMany(VariationMin::class, 'group');
	}


}
