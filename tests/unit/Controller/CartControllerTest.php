<?php

use PHPUnit\Framework\TestCase;

require(__DIR__.'/../../../src/Controller/CartController.php');


class CartControllerTest extends TestCase {

    private $cartController;
    private $products;

    protected function setUp(): void
    {

        $this->products = ['T-shirt','Blouse','Pants','Jacket','Shoes'];
        $this->cartController = new CartController($this->products);

    }

    public function testCalculateSubTotal () {
        
        $subTotal = 386.95;
        $this->assertEquals($subTotal, $this->cartController->calculateSubTotal());
    }

    public function testCalculateTotalVat () {
        
        $vatTotal = 54.173;
        $this->assertEquals($vatTotal, $this->cartController->calculateTotalVat());
    }

    public function testCalculateTotalShippingFees () {

        $shippingTotal = 110;
        $this->assertEquals($shippingTotal, $this->cartController->calculateTotalShippingFees());
        
    }

    public function testCalculateTotalAfterDiscount () {

        $feesAfterDiscount = 433.129;
        $this->assertEquals($feesAfterDiscount, $this->cartController->calculateTotalAfterDiscount());
    }

    public function testManipulateCart() {

        $productsObjectsArray = $this->cartController->manipulateCart($this->products);

        for ($i=0; $i < count($productsObjectsArray) ; $i++) { 
            $this->assertInstanceOf('Product' , $productsObjectsArray[$i]);
            $this->assertEquals( $productsObjectsArray[$i]->getItemType() , $this->products[$i]);
        }           

    }

}
    