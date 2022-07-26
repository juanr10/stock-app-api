<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductsStock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity'];

    protected $hidden = ['id', 'created_at'];

    protected $dates = ['created_at', 'updated_at'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
