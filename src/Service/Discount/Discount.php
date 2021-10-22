<?php


/**
 * The Discount Class uses DiscountContractInterface interface to call the algorithm defined by discount
 * Strategies.
 */


class Discount {

    /**
     * Discount Class maintains a reference to one of the Strategy
     * objects. The Discount does not know the concrete class of a strategy. It
     * should work with all strategies via the DiscountContractInterface interface.
     */
    private $strategy; 
    
    public function __construct()
    {

    }

    /**
     * Replacing a Strategy object at runtime.
     */

    public function setStrategy(DiscountContractInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function calculateTotalDiscount( $fees )
    {
        $feesAfterDiscount = $this->strategy->applyStrategyDiscount( $fees );
        return $feesAfterDiscount;
    }

}

