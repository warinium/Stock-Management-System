<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'barcode',
        'image',
        'status',
        'price',
        'purchase_price',
        'quantity',
    ];

    public function stock(): HasOne
    {
        return $this->hasOne(CurrentStock::class, 'id', 'id');
    }

    public function getCurrentStock()
    {
        if ($this->stock())
            $this->stock->quantity;
        else
            return 0;
    }
}
