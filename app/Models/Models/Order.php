<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id'
    ];

    public function items()
    {

        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getCustomerName()
    {
        if ($this->customer())
            return $this->customer->first_name . ' ' . $this->customer->last_name;
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
