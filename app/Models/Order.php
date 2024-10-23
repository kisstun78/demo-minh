<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = ['table', 'total', 'customerName', 'phone'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('qty', 'total') // Lấy cả số lượng và tổng tiền cho từng sản phẩm
            ->withTimestamps();
    }
}
