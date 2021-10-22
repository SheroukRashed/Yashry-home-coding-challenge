<?php

use PHPUnit\Framework\TestCase;


class StrategyBTest extends TestCase {

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

        $this->strategy = new StrategyB('50% off jacket: ', 50);

    }

    public function testStrategy()
    {
        $this->assertInstanceOf('StrategyB', $this->strategy);
    }

    public function testApplyStrategyDiscount()
    {
        //  Test With 1 Jacket In Cart And 2 Tops
        $products = [$this->product_1, $this->product_2, $this->product_3, $this->product_4, $this->product_5];
        $this->cart->setProducts($products);
        $this->strategy = new StrategyB('50% off jacket: ', 50);
        $this->assertEquals(300-99.995 ,$this->strategy->applyStrategyDiscount(300));

        //  Test With 1 Jacket In Cart And 1 Tops
        $products = [$this->product_2, $this->product_3, $this->product_4, $this->product_5];
        $this->cart->setProducts($products);
        $this->assertEquals(300 ,$this->strategy->applyStrategyDiscount(300));

        //  Test With No Jackets In Cart And 2 Tops
        $products = [$this->product_1, $this->product_2, $this->product_3, $this->product_5];
        $this->cart->setProducts($products);
        $this->assertEquals(300 ,$this->strategy->applyStrategyDiscount(300));

         //  Test With 2 Jackets In Cart And 2 Tops
         $products = [$this->product_1, $this->product_2, $this->product_3, $this->product_4, $this->product_4, $this->product_5];
         $this->cart->setProducts($products);
         $this->assertEquals(300-99.995 ,$this->strategy->applyStrategyDiscount(300));


        //  Test With 2 Jackets In Cart And 4 Tops
        $products = [$this->product_1, $this->product_2,$this->product_2,$this->product_2, $this->product_3, $this->product_4, $this->product_4, $this->product_5];
        $this->cart->setProducts($products);
        $this->assertEquals(300-(2*99.995) ,$this->strategy->applyStrategyDiscount(300));
    }


    public function testUpdateReceiptDetails()
    {
        $products = [$this->product_1, $this->product_2, $this->product_3, $this->product_4, $this->product_5];
        $this->cart->setProducts($products);
        $this->strategy = new StrategyB('50% off jacket: ', 50);
        $this->strategy->applyStrategyDiscount(300);
        $receiptDetails = $this->cart->getReceiptDetails();
        $this->assertNotEmpty($receiptDetails);
        $this->assertEquals( "\t50% off jacket: -$99.995", end($receiptDetails));

    }
}