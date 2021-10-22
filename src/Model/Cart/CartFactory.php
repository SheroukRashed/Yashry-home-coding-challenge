<?php

require(__DIR__.'/Class/Cart.php');

class CartFactory extends Factory
{

    public function __construct()
    {
       
    }

    public function getObject() : CartModelInterface
    {
        return Cart::getInstance();
    }
}