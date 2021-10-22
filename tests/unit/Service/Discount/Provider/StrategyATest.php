<?php

use PHPUnit\Framework\TestCase;

require 'src/Service/Discount/Contract/DiscountContractInterface.php';
require 'src/Service/Discount/Provider/StrategyA.php';
require 'src/Service/Discount/Provider/StrategyB.php';
require 'src/Service/Discount/Provider/StrategyC.php';
require 'src/Service/Discount/Discount.php';
require 'src/Model/Factory.php';
require 'src/Model/Cart/CartFactory.php';
require 'src/Model/ShippingFees/ShippingFeesFactory.php';
require 'src/Model/Product/ProductFactory.php';
require 'config/constants.php';

class StrategyATest extends TestCase {

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

        $this->strategy = new StrategyA('10% off shoes: ', 10);
    }

    public function testStrategy()
    {
        $this->assertInstanceOf('StrategyA', $this->strategy);
    }

    public function testApplyStrategyDiscount()
    {

        //  Test With No Shoes
        $products = [$this->product_1, $this->product_2, $this->product_3, $this->product_4];
        $this->cart->setProducts($products);
        $this->strategy = new StrategyA('10% off shoes: ', 10);
        $this->assertEquals(300 ,$this->strategy->applyStrategyDiscount(300));

        //  Test With 1 Shoes
        $products = [$this->product_1, $this->product_2, $this->product_3, $this->product_4, $this->product_5];
        $this->cart->setProducts($products);
        $this->assertEquals(300-7.999 ,$this->strategy->applyStrategyDiscount(300));

         //  Test With 2 Shoes
         $products = [$this->product_1, $this->product_2, $this->product_3, $this->product_4, $this->product_5, $this->product_5];
         $this->cart->setProducts($products);
         $this->assertEquals(300-(2*7.999) ,$this->strategy->applyStrategyDiscount(300));

    }

    public function testUpdateReceiptDetails()
    {
        $products = [$this->product_1, $this->product_2, $this->product_3, $this->product_4, $this->product_5];
        $this->cart->setProducts($products);
        $this->strategy = new StrategyA('10% off shoes: ', 10);
        $this->strategy->applyStrategyDiscount(300);
        $receiptDetails = $this->cart->getReceiptDetails();
        $this->assertNotEmpty($receiptDetails);
        $this->assertEquals( "\t10% off shoes: -$7.999", end($receiptDetails));

    }
}