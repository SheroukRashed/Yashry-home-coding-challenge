<?php

use PHPUnit\Framework\TestCase;

require(__DIR__.'/../../../src/Model/Factory.php');
require(__DIR__.'/../../../src/Model/Cart/CartFactory.php');


class CartTest extends TestCase {

    private $cart;
    private $products;

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

        $this->products = [$product_1, $product_2, $product_3, $product_4, $product_5];
        $this->cart->setProducts($this->products);

    }
 
    public function testGetInstance()
    {
        $this->assertInstanceOf('Cart', $this->cart);
    }

    public function testSetProductGetProduct()
    {
        $this->assertEquals($this->products, $this->cart->getProducts());
    }

    public function testSetSubTotalGetSubTotal()
    {
        $subTotal = 386.95;
        $this->cart->setSubTotal($subTotal);
        $this->assertEquals($subTotal, $this->cart->getSubTotal());
    }

    public function testSetTotalVatGetTotalVat()
    {
        $vatTotal = 54.173;
        $this->cart->setVatTotal($vatTotal);
        $this->assertEquals($vatTotal, $this->cart->getVatTotal());
    }

    public function testSetTotalShippingFeesGetTotalShippingFees () {

        $shippingTotal = 110;
        $this->cart->setTotalShippingFees($shippingTotal);
        $this->assertEquals($shippingTotal, $this->cart->getTotalShippingFees());
    }


    public function testCalculateTotalAfterDiscount () {

        $totalFeesAfterDiscount = 433.129;
        $this->cart->setTotalAfterDiscount($totalFeesAfterDiscount);
        $this->assertEquals($totalFeesAfterDiscount, $this->cart->getTotalAfterDiscount());
    }

    public function testSetReceiptDetailsGetReceiptDetails () {

        $receiptDetailsString = "Trail";
        $this->cart->setReceiptDetails($receiptDetailsString);
        $this->assertEquals(1, count($this->cart->getReceiptDetails()));

        $receiptDetailsString = "Trail_2";
        $this->cart->setReceiptDetails($receiptDetailsString);
        $this->assertEquals(2, count($this->cart->getReceiptDetails()));
        $receiptDetails = $this->cart->getReceiptDetails();
        $lastReceiptDetailsString = end($receiptDetails);
        $this->assertEquals("Trail_2", $lastReceiptDetailsString);

        $receiptDetailsText = "Trail_3";
        $this->cart->setReceiptDetails($receiptDetailsText);
        $this->assertContains("Trail_3", $this->cart->getReceiptDetails());

    }

    public function tearDown(): void
    {
        $this->cart->tearDown();
    }

}