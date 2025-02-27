<?php

namespace App\Business;

/**
 * A discounted cart is a sumamry of how a cart was discounted, including original price, discounted price, and which discounts were applied.
 */
class DiscountedCart
{
    // TODO use private properties and public getters/setters
    public float $original_total_price;
    public float $discounted_total_price;
    public array $applied_discounts;

    public function __construct(
        float $original_total_price,
        float $discounted_total_price,
        array $applied_discounts,
    ) {
        $this->original_total_price = $original_total_price;
        $this->discounted_total_price = $discounted_total_price;
        $this->applied_discounts = $applied_discounts;
    }
}
