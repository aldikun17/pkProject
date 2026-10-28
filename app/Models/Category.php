<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "event_categories";
    protected $fillable = ["category_name", "category_description"];
}
