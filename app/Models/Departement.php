<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departement extends Model
{
    //
    use SoftDeletes;
    protected $guarded=['id'];

    public function education()
    {
        return $this->belongsTo(Education::class);
    }
}
