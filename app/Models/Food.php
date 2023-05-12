<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'name',
        'image',
        'price',
        'rate',
        'discount',
        'description',
    ];

    public function FoodOrigins()
    {
        return $this->hasMany(FoodOrigin::class);
    }
}
