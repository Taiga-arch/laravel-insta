<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    protected $table = "category_post";
    public $timestamps = false;
    protected $fillable = ['category_id', 'post_id'];

    // category_post belongs to categories
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
