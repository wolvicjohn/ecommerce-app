<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['productname', 'quantity', 'price', 'category_id','image'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
