<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class PackagePrice extends Model
{
    use SoftDeletes;

    protected $fillable = ['type', 'package_for', 'price_per_unit'];
    protected $table = 'package_costings';

    public function getAmount($type, $for)
    {
        return $this->select('price_per_unit')->where('type', $type)->where('package_for', $for)->pluck('price_per_unit')->first();
    }

}
