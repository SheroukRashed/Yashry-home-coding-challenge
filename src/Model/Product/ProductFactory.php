<?php


require(__DIR__.'/Class/Product.php');


class ProductFactory extends Factory
{

    private $id;           //: BigInt
    private $itemType;     //: String
    private $itemPrice;    //: Float
    private $itemWeight;   //: Float
    private $shippingFees; //: ShippingFees
    private $vatRatio;     //: Float

    public function __construct( $id , $itemType , $shippingFees , $itemPrice , $itemWeight , $vatRatio)
    {
        $this->id = $id;
        $this->itemType = $itemType;
        $this->shippingFees = $shippingFees;
        $this->itemPrice = $itemPrice;
        $this->itemWeight = $itemWeight;        
        $this->vatRatio = $vatRatio;
    }

    /**
     * When the factory method is used inside the Creator's business logic, the
     * subclasses may alter the logic indirectly by returning different types of
     * the products from the factory method.
     */

    public function getObject() : ProductModelInterface
    {
        return new Product( $this->id , $this->itemType , $this->shippingFees , $this->itemPrice , $this->itemWeight , $this->vatRatio);
    }
}