<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryCourse extends Model
{
    //
    use SoftDeletes;
    protected $guarded=['id'];
}
