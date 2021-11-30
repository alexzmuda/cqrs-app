<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Product
 * @package App\Modules\Recipe\Models
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Recipe\Models\Recipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Recipe\Models\Recipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Recipe\Models\Recipe query()
 * @mixin \Eloquent
 * @property int id
 * @property string name
 * @property string code
 * @property float price
 * @property \Illuminate\Support\Carbon|null created_at
 * @property \Illuminate\Support\Carbon|null updated_at
 * @property-read Collection|RecipeIngredient[] ingredients
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Recipe\Models\Recipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Recipe\Models\Recipe whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Recipe\Models\Recipe whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Recipe\Models\Recipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Recipe\Models\Recipe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Recipe\Models\Recipe findOrFail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Recipe\Models\Recipe create($value)
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
}

