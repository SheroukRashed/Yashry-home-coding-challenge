<?php

use PHPUnit\Framework\TestCase;


class DiscountTest extends TestCase
{
    
    private $cart;
    private $product_1;
    private $product_2;
    private $product_3;
    private $product_4;
    private $product_5;
    private $strategy;

    protected function setUp(): void
    {
        $cartFactory = new CartFactory();
        $this->cart = $cartFactory->getObject();


        $shippingFeesFactory_1 = new ShippingFeesFactory(1,'US', 2);
        $shippingFeesFactory_2 = new ShippingFeesFactory(2 , 'UK' , 3);
        $shippingFeesFactory_3 = new ShippingFeesFactory(3 , 'CN' , 2);
        $shippingFees_1 = $shippingFeesFactory_1->getObject();
        $shippingFees_2 = $shippingFeesFactory_2->getObject();
        $shippingFees_3 = $shippingFeesFactory_3->getObject();

        $productFactory_1 = new ProductFactory(1 , 'T-shirt' , $shippingFees_1 , 30.99 , 200 , 0.14);
        $productFactory_2 = new ProductFactory(2 , 'Blouse' , $shippingFees_2 , 10.99 , 300 , 0.14);
        $productFactory_3 = new ProductFactory(3 , 'Pants' , $shippingFees_2 , 64.99 , 900 , 0.14);
        $productFactory_4 = new ProductFactory(4 , 'Jacket' , $shippingFees_1 , 199.99 , 2200 , 0.14);
        $productFactory_5 = new ProductFactory(6 , 'Shoes' , $shippingFees_3 , 79.99 , 1300 , 0.14);
        $this->product_1 = $productFactory_1->getObject();
        $this->product_2 = $productFactory_2->getObject();
        $this->product_3 = $productFactory_3->getObject();
        $this->product_4 = $productFactory_4->getObject();
        $this->product_5 = $productFactory_5->getObject();


        $products = [$this->product_1, $this->product_2, $this->product_3, $this->product_4, $this->product_5];
        $this->cart->setProducts($products);
    }

    
    public function testCalculateTotalDiscount()
    {
        $discount = new Discount();
        $products = [$this->product_1, $this->product_2, $this->product_3, $this->product_4, $this->product_5];

        // Test StrategyA
        $this->strategy = new StrategyA('10% off shoes: ', 10);
        $this->cart->setProducts($products);
        $discount->setStrategy($this->strategy);
        $this->assertEquals(300-7.999, $discount->calculateTotalDiscount(300));

        // Test StrategyB
        $this->strategy = new StrategyB('50% off jacket: ', 50);
        $discount->setStrategy($this->strategy);
        $this->assertEquals(300-99.995, $discount->calculateTotalDiscount(300));

         // Test StrategyC
         $this->strategy = new StrategyC('$10 of shipping: ', 10);
         $discount->setStrategy($this->strategy);
         $this->cart->setTotalShippingFees(300);
         $this->assertEquals(300-10, $discount->calculateTotalDiscount(300));

        
    }
}