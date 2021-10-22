<?php


class StrategyC implements DiscountContractInterface {

    private $receiptText;      //: String
    private $discountValue;    //: Float
    private $cart;

    public function __construct( $receiptText, $discountValue )
    {
        $this->receiptText = $receiptText;
        $this->discountValue = $discountValue;
        $cartFactory = new CartFactory();
        $this->cart = $cartFactory->getObject();
    }

    /**
     * This Discount Strategy would be applied when client buy a two or more products of any type
     */

    public function applyStrategyDiscount( $fees )
    {
        $products = $this->cart->getProducts();
        $feesToBeDiscounted = 0;
        $feesAfterDiscount = 0;
        
        if( count($products) >= 2 ){
            $shippingFees = $this->cart->getTotalShippingFees();
            if( $shippingFees >= $this->discountValue ){
                $feesToBeDiscounted = $this->discountValue;
            }else{
                $feesToBeDiscounted = $shippingFees;
            }
        }
        $feesAfterDiscount = $fees - $feesToBeDiscounted;
        
        $this->updateReceiptDetails( $fees , $feesAfterDiscount , $feesToBeDiscounted);
        return $feesAfterDiscount;
    }

    public function updateReceiptDetails( $fees , $feesAfterDiscount , $feesToBeDiscounted) {

        if( $feesAfterDiscount != $fees && !in_array(__DISCOUNT_TEXT__,$this->cart->getReceiptDetails())){
            $this->cart->setReceiptDetails(__DISCOUNT_TEXT__);
        }

        if( $feesAfterDiscount != $fees ){
            $this->cart->setReceiptDetails("\t".$this->receiptText.'-'.__CURRUNCY__.$feesToBeDiscounted);
        }
    } 

}

