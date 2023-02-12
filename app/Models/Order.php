<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'orderdetail_id ',
        'total',
        'estado',
        'fecha'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orderdetail() {
        // belongsTo() es para una relacion de uno a muchos y hasMany() es para una relacion de muchos a uno y hasOne() es para una relacion de uno a uno
        return $this->belongsTo(Orderdetail::class);
    }

    


}