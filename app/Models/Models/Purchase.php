<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'provider_id',
        'user_id'
    ];

    public function items()
    {

        return $this->hasMany(PurchaseItem::class);
    }

    public function payments()
    {
        return $this->hasMany(PurchasePayment::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function getProviderName()
    {
        if ($this->provider())
            return $this->provider->first_name . ' ' . $this->provider->last_name;
    }

    public function getAmount()
    {
        return $this->items->map(function ($i) {
            return $i->price * $i->quantity;
        })->sum();
    }
    public function getReceivedAmount()
    {
        return $this->payments->map(function ($i) {
            return $i->amount;
        })->sum();
    }

    public function formattedAmount()
    {
        return number_format($this->getAmount(), 2);
    }

    public function formattedAmountPayement()
    {
        return number_format($this->getReceivedAmount(), 2);
    }
}
