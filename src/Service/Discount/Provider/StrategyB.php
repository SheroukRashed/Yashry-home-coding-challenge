<?php


class StrategyB implements DiscountContractInterface {

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
     * This Discount Strategy would be applied when client buy any two tops 
     * (t-shirt or blouse) and get any jacket half its price
     * 
     * here I've made an asumption that this discount can be made twice 
     * for example if you bought 4 tops and 2 jakets this disount would 
     * remove half the price of the first jaket and half the price of the second jaket
     * 
     * for sclability purposes if you have more than one jaket in the database with different
     * prices the discount would be applied on the jaket of the least cost
     */

    public function applyStrategyDiscount( $fees )
    {
        $jaketsPrices = array();
        $products = $this->cart->getProducts();
        $feesToBeDiscounted = 0;
        $feesAfterDiscount = 0;
        $topsCounter = 0;
        
        foreach ($products as $product){
            if( $product->getItemType() == 'T-shirt' || $product->getItemType() == 'Blouse' ){
                $topsCounter++;
            }
            if( $product->getItemType() == 'Jacket' ){
                array_push($jaketsPrices , $product->getItemPrice());
            }
        }

        $topsCounter = (int) ($topsCounter/2);

        for ($i=0; $i < $topsCounter; $i++) { 
            if( count($jaketsPrices) >= 1 ){
                $minJacketPrice = min($jaketsPrices);
                $feesToBeDiscounted += $minJacketPrice * ($this->discountRate / 100);
                $key = array_search( $minJacketPrice , $jaketsPrices );
                if ( isset($key) ) {
                    unset($jaketsPrices[$key]);
                }
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

