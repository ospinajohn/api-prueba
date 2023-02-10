<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model {
    use HasFactory;

    protected $fillable = [
        'cantidad',
        'precio',
        'total',
        'product_id '
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'precio' => 'float',
        'total'  => 'float',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}