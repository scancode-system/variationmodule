<?php

namespace Modules\Variation\Entities;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $fillable = ['alias', 'table', 'field'];
}
