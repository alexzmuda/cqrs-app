<?php

namespace App\Modules\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Product
 * @package App\Modules\Order\Models
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Order\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Order\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Order\Models\Order query()
 * @mixin \Eloquent
 * @property int id
 * @property string name
 * @property string codes
 * @property float price
 * @property \Illuminate\Support\Carbon|null created_at
 * @property \Illuminate\Support\Carbon|null updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Order\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Order\Models\Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Order\Models\Order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Order\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Order\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Order\Models\Order findOrFail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Order\Models\Order create($value)
 */
class Order extends Model
{
    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];
}

