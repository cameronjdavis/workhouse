This is Cameron D's git repo for the Workhouse technical test. Emjoy!

# Code structure

My code has models, tables and migrations for a `Cart` with zero or more `CartItem`. Discounts have a `Discount` model, table and migration. The discounting logic is done by [./app/Business/CartDiscounter.php](./app/Business/CartDiscounter.php).

# Demonstrating code

You can run the tests to see the code in action.

```php
./vendor/bin/sail artisan migrate --env=testing
./vendor/bin/sail artisan test
```

# Requirements

A shopper has a cart of items. Before paying, we need to apply zero or more discounts to the cart. The two types of discount are:

* A percentage off the entire cart, e.g. %15 off original cart total.
* A fixed amount off the entire cart, e.g. $10 off cart total.

Multiple discounts are allowed, e.g. Apply a 15% discount to the original cart total, and apply a $10 discount to the cart total.

No discount should be applied that will reduce the cart total to below zero.

# Requirements not being considered

* Limit discounts to certain product categories.
