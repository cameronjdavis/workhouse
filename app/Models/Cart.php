<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function getCartTotalPrice(): float
    {
        $price = 0.0;
        foreach($this->cartItems as $item) {
            $price += $item->quantity * $item->price;
        }
        return $price;
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
