<?php

namespace App\Business;

use App\Models\Cart;
use App\Models\Discount;
use Carbon\Carbon;
use DateTime;
use Exception;

class CartDiscounter
{
    public function discountCart(Cart $cart, array $discounts): DiscountedCart
    {
        $cartTotalPrice = $cart->getCartTotalPrice();
        $discountedTotalPrice = $cartTotalPrice;
        $nextDiscount = 0.0;
        $appliedDiscounts = [];
        $now = Carbon::now();
        foreach ($discounts as $discount) {
            if ($now > $discount->active_to || $now < $discount->active_from) {
                continue;
            }

            if ($discount->discount_type == Discount::DISCOUNT_TYPE_FIXED) {
                $nextDiscount = $discount->amount;
            } elseif ($discount->discount_type == Discount::DISCOUNT_TYPE_PERCENTAGE) {
                $nextDiscount = $cartTotalPrice * $discount->amount;
            } else {
                // TODO log this unknown discount type, we will continue executing so that sales can still be made
                continue;
            }

            if($cartTotalPrice - $nextDiscount > 0.0) {
                $discountedTotalPrice = $cartTotalPrice - $nextDiscount;
                $appliedDiscounts[] = $discount;
            }
        }
        return $discountedCart = new DiscountedCart(
            $cartTotalPrice,
            $discountedTotalPrice,
            $appliedDiscounts,
        );
    }
}
