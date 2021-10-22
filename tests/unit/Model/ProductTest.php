<?php

use PHPUnit\Framework\TestCase;

require(__DIR__.'/../../../src/Model/Product/ProductFactory.php');

class ProductTest extends TestCase {
    
    private $product_1;
    
    protected function setUp(): void
    {
        $shippingFeesFactory_1 = new ShippingFeesFactory(1,'US', 2);
        $shippingFees_1 = $shippingFeesFactory_1->getObject();
    
        $productFactory_1 = new ProductFactory(1 , 'T-shirt' , $shippingFees_1 , 30.99 , 200 , 0.14);
        $this->product_1 = $productFactory_1->getObject();
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('Product', $this->product_1);
    }

    public function testGetItemType() {

        $this->assertEquals('T-shirt', $this->product_1->getItemType());
    }

    public function testGetItemPrice() {

        $this->assertEquals(30.99, $this->product_1->getItemPrice());
    }

    public function testGetItemVat() {

        $this->assertEquals(30.99 * 0.14, $this->product_1->getItemVat());
    }

    public function testGetItemWeight() {

        $this->assertEquals(200, $this->product_1->getItemWeight());
    }

    public function testGetShippingFeesPerTotalWeight() {

        $this->assertEquals(2 * (200 / 100), $this->product_1->getShippingFeesPerTotalWeight());
    }

}