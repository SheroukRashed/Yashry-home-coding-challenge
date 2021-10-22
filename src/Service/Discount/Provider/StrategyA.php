<?php


class StrategyA implements DiscountContractInterface {

    private $receiptText;     //: String
    private $discountRate;    //: Float
    private $cart;


    public function __construct( $receiptText, $discountRate )
    {
        $this->receiptText = $receiptText;
        $this->discountRate = $discountRate;
        $cartFactory = new CartFactory();
        $this->cart = $cartFactory->getObject();
    }

    /**
     * This Discount Strategy would be applied when client buy a product of type shoes
     */

    public function applyStrategyDiscount( $fees )
    {
        $products = $this->cart->getProducts();
        $feesToBeDiscounted = 0;
        $feesAfterDiscount = 0;
        foreach ($products as $product){
            if( $product->getItemType() == 'Shoes' ){
                $productPrice = $product->getItemPrice();
                $feesToBeDiscounted += $productPrice * ($this->discountRate / 100);
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

