<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsStock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity'];

    protected $hidden = ['id', 'created_at'];

    public function getUpdatedAtAttribute()
    {
        return date('d-m-Y H:i:s', strtotime($this->attributes['updated_at']));
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
