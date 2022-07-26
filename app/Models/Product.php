<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    protected $casts = [
        'price' => 'float',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function stock()
    {
        return $this->hasOne(ProductsStock::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'product_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'product_id');
    }
}
