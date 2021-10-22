<?php

require(__DIR__.'/../Contract/ShippingFeesModelInterface.php');


class ShippingFees implements ShippingFeesModelInterface
{
    private $id;       //: BigInt
    private $country;  //: String
    private $rate;     //: Float
    
    public function __construct( $id , $country , $rate) {

        $this->id = $id;
        $this->country = $country;
        $this->rate = $rate;

    }

    public function setCountry($country) {

        $this->country = $country;
    }

    public function getCountry() {

        return $this->country;
    }

    public function setRate($rate) {

        $this->rate = $rate;
    }

    public function getRate() {

        return $this->rate;
    }
}