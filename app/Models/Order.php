<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes;
    protected $guarded=['id'];

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
