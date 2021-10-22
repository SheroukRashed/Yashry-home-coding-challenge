<?php

use PHPUnit\Framework\TestCase;


class StrategyCTest extends TestCase {

    private $cart;
    private $products;
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
        $product_1 = $productFactory_1->getObject();
        $product_2 = $productFactory_2->getObject();
        $product_3 = $productFactory_3->getObject();
        $product_4 = $productFactory_4->getObject();
        $product_5 = $productFactory_5->getObject();

        $this->strategy = new StrategyC('$10 of shipping: ', 10);


        $this->products = [$product_1, $product_2, $product_3, $product_4, $product_5];
        $this->cart->setProducts($this->products);

    }

    public function testStrategy()
    {
        $this->assertInstanceOf('StrategyC', $this->strategy);
    }

    public function testApplyStrategyDiscount()
    {
        //  Test When Shipping Fees > 10 $
        $this->cart->setTotalShippingFees(22);
        $this->strategy = new StrategyC('$10 of shipping: ', 10);
        $this->assertEquals(300-10 ,$this->strategy->applyStrategyDiscount(300));

        //  Test When Shipping Fees < 10 $
        $this->cart->setTotalShippingFees(2);
        $this->assertEquals(300-2 ,$this->strategy->applyStrategyDiscount(300));

        //  Test When Shipping Fees = 10 $

        $this->cart->setTotalShippingFees(10);
        $this->assertEquals(300-10 ,$this->strategy->applyStrategyDiscount(300));

    }

    public function testUpdateReceiptDetails()
    {
        $this->cart->setTotalShippingFees(22);
        $this->strategy = new StrategyC('$10 of shipping: ', 10);
        $this->strategy->applyStrategyDiscount(300);
        $receiptDetails = $this->cart->getReceiptDetails();
        $this->assertNotEmpty($receiptDetails);
        $this->assertEquals( "\t$10 of shipping: -$10", end($receiptDetails));

    }

}