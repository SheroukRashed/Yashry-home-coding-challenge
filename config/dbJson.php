<?php

/**
 * This array carry all existing products and their counties along with their shipping rates.
 * later this array will be used to create Product objects ,this aproach is used to 
 * compensate the absence of a database through which we would have saved and retrieved data
 */
$products = array(
    array(
        'id' => 1,
        'name' => 'T-shirt',
        'shippingFeesId' => 1,
        'weight' => 200,
        'price' => 30.99
    ),
    array(
        'id' => 2,
        'name' => 'Blouse',
        'shippingFeesId' => 2,
        'weight' => 300,
        'price' => 10.99
    ),
    array(
        'id' => 3,
        'name' => 'Pants',
        'shippingFeesId' => 2,
        'weight' => 900,
        'price' => 64.99
    ),
    array(
        'id' => 4,
        'name' => 'Sweatpants',
        'shippingFeesId' => 3,
        'weight' => 1100,
        'price' => 84.99
    ),
    array(
        'id' => 5,
        'name' => 'Jacket',
        'shippingFeesId' => 1,
        'weight' => 2200,
        'price' => 199.99
    ),
    array(
        'id' => 6,
        'name' => 'Shoes',
        'shippingFeesId' => 3,
        'weight' => 1300,
        'price' => 79.99
    )
);

$shippingFees = array(
    array(
        'id' => 1,
        'country' => 'US',
        'rate' => 2,
    ),
    array(
        'id' => 2,
        'country' => 'UK',
        'rate' => 3,
    ),
    array(
        'id' => 3,
        'country' => 'CN',
        'rate' => 2,
    )
);

define("__PRODUCTS__", $products);
define("__SHIPPINGFEES__", $shippingFees);