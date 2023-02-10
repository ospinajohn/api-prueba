<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'nombre',
        'image',
        'precio',
        'stock',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function getImageAttribute($value) {
        return json_decode($value);
    }

    public function setImageAttribute($value) {
        $this->attributes['image'] = json_encode($value);
    }


}