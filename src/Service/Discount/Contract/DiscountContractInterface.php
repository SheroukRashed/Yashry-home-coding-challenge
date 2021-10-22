<?php


/**
 * The DiscountContractInterface declares operations common to all supported versions
 * of discount Strategies.
 */

 
interface DiscountContractInterface {
    public function applyStrategyDiscount($fees);
    public function updateReceiptDetails( $fees , $feesAfterDiscount , $feesToBeDiscounted);
}