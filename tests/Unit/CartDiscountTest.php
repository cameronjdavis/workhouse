<?php

namespace Tests\Unit;

use App\Models\Cart;
use Tests\TestCase;
use App\Business\CartDiscounter as Subject;
use App\Models\CartItem;
use App\Models\Discount;
use Carbon\Carbon;

class CartDiscountTest extends TestCase
{
    private Subject $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new Subject();
    }

    public function test_no_cart_items(): void
    {
        $cart = new Cart();

        $actual = $this->subject->discountCart($cart, []);

        $this->assertSame(0.0, $actual->original_total_price);
        $this->assertSame(0.0, $actual->discounted_total_price);
        $this->assertSame([], $actual->applied_discounts);
    }

    public function test_one_cart_item(): void
    {
        $cart = new Cart();
        $cart->save();
        $item = new CartItem([
            'cart_id' => $cart->id,
            'quantity' => 1,
            'price' => 123.45,
        ]);
        $item->save();

        $actual = $this->subject->discountCart($cart, []);

        $this->assertSame(123.45, $actual->original_total_price);
        $this->assertSame(123.45, $actual->discounted_total_price);
        $this->assertSame([], $actual->applied_discounts);
    }

    public function test_fixed_discount(): void
    {
        $cart = new Cart();
        $cart->save();
        $item = new CartItem([
            'cart_id' => $cart->id,
            'quantity' => 1,
            'price' => 100.00,
        ]);
        $item->save();

        $discounts = [
            new Discount([
                'discount_type' => Discount::DISCOUNT_TYPE_FIXED,
                'amount' => 12.3,
                'active_from' => Carbon::now()->yesterday(),
                'active_to' => Carbon::now()->tomorrow(),
            ]),
        ];

        $actual = $this->subject->discountCart($cart, $discounts);

        $this->assertSame(100.00, $actual->original_total_price);
        $this->assertSame(100.0 - 12.3, $actual->discounted_total_price);
        $this->assertSame($discounts, $actual->applied_discounts);
    }

    // TODO test percentage discount
    // TODO test multiple discounts
    // TODO test don't let total drop below $0
}
