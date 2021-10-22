<?php

require(__DIR__.'/Class/ShippingFees.php');


class ShippingFeesFactory extends Factory
{
    private $id;       //: BigInt
    private $country;  //: String
    private $rate;     //: Float
    
    
    public function __construct( $id , $country , $rate) {

        $this->id = $id;
        $this->country = $country;
        $this->rate = $rate;

    }


    public function getObject() : ShippingFeesModelInterface
    {
        return new ShippingFees( $this->id , $this->country , $this->rate );
    }
}
