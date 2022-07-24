<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    protected $casts = [
        'price' => 'float',
    ];

    public function getCreatedAtAttribute()
    {
        return date('d-m-Y H:i:s', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date('d-m-Y H:i:s', strtotime($this->attributes['updated_at']));
    }

    public function stock()
    {
        return $this->hasOne(ProductsStock::class);
    }
}
