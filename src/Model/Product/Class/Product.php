<?php

require(__DIR__.'/../Contract/ProductModelInterface.php');


class Product implements ProductModelInterface
{
    private $id;           //: BigInt
    private $itemType;     //: String
    private $itemPrice;    //: Float
    private $itemWeight;   //: Float
    private $shippingFees; //: ShippingFees
    private $vat;          //: Float
    

    public function __construct( $id , $itemType , $shippingFees , $itemPrice , $itemWeight , $vatRatio) {

        $this->id = $id;
        $this->itemType = $itemType;
        $this->shippingFees = $shippingFees;
        $this->itemPrice = $itemPrice;
        $this->itemWeight = $itemWeight;        
        $this->vat = $itemPrice * $vatRatio;

    }

    public function getShippingFeesPerTotalWeight() {

        $shippingFeesPerTotalWeight = $this->shippingFees->getRate() * ($this->itemWeight / 100);
        return $shippingFeesPerTotalWeight;
    }


    public function setShippingFees($shippingFees) {

        $this->shippingFees = $shippingFees;
    }

    public function getShippingFees() {

        return $this->shippingFees;
    }

    public function setItemType($itemType){

        $this->itemType = $itemType;

    }

    public function getItemType() {

        return $this->itemType;
    }

    public function setItemPrice($itemPrice){

        $this->itemPrice = $itemPrice;
    }

    public function getItemPrice() {

        return $this->itemPrice;
    }

    public function setItemVat($vat) {

        $this->vat = $vat;
    }


    public function getItemVat() {

        return $this->vat;
    }

    public function setItemWeight($itemWeight) {

        $this->itemWeight = $itemWeight;
    }

    public function getItemWeight(){

        return $this->itemWeight;
    }

}