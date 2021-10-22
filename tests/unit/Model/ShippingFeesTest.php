<?php

use PHPUnit\Framework\TestCase;

require(__DIR__.'/../../../src/Model/ShippingFees/ShippingFeesFactory.php');

class ShippingFeesTest extends TestCase {
    
    private $shippingFees_1;
  
    protected function setUp(): void
    {
        $shippingFeesFactory_1 = new ShippingFeesFactory(1, 'US', 2);
        $this->shippingFees_1 = $shippingFeesFactory_1->getObject();
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('ShippingFees', $this->shippingFees_1);
    }

    public function testGetCountry() {

        $this->assertEquals('US', $this->shippingFees_1->getCountry());
    }

    public function testGetRate() {

        $this->assertEquals(2, $this->shippingFees_1->getRate());
    }

}