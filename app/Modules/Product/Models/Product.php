<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Product
 * @package App\Modules\Product\Models
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Product\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Product\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Product\Models\Product query()
 * @mixin \Eloquent
 * @property int id
 * @property string name
 * @property string code
 * @property float price
 * @property \Illuminate\Support\Carbon|null created_at
 * @property \Illuminate\Support\Carbon|null updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Product\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Product\Models\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Product\Models\Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Product\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Product\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Product\Models\Product findOrFail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Product\Models\Product create($value)
 */
class Product extends Model
{
    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'code',
        'price'
    ];
}

