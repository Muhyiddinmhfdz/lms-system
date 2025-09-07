<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    //
    use SoftDeletes;
    protected $guarded=['id'];

    public function category()
    {
        return $this->belongsTo(CategoryCourse::class,'category_course_id','id');
    }

    public function details()
    {
        return $this->hasMany(CourseDetail::class);
    }
    
}
