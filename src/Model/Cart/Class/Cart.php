<?php

require(__DIR__.'/../Contract/CartModelInterface.php');
 /**
 * Cart class generated Singleton's instance is stored in a static field. 
 * This implementation lets you subclass the Singleton class while keeping 
 * just one instance of each subclass around
 */


class Cart implements CartModelInterface{

    private static $instances;   
    private $products;                  //: [Product]
    private $subTotal;                  //: Float
    private $vatTotal;                  //: Float
    private $shippingTotal;             //: Float
    private $totalFeesAfterDiscount;    //: Float
    private $receiptDetails = array();  //: [String]

    /**
     * The Singleton's constructor should always be private to prevent direct
     * construction calls with the `new` operator.
     */
    protected function __construct() { }


    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
     * This implementation lets you subclass the Singleton class while keeping
     * just one instance of each subclass around.
     */
    public static function getInstance()
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function setProducts  ( $products ) {

        $this->products = $products;
    }

    public function getProducts  () {

        return $this->products;
    }


    public function setSubTotal ($subTotal) {

        $this->subTotal = $subTotal;
    }

    public function getSubTotal(){
        
        return $this->subTotal;
    }

    public function setVatTotal ($vatTotal) {

        $this->vatTotal = $vatTotal;
    }

    public function getVatTotal(){
        
        return $this->vatTotal;
    }


    public function setTotalShippingFees ($shippingTotal) {

        $this->shippingTotal = $shippingTotal;
    }

    public function getTotalShippingFees () {

        return $this->shippingTotal;
    }


    public function setTotalAfterDiscount ($totalFeesAfterDiscount) {

        $this->totalFeesAfterDiscount = $totalFeesAfterDiscount;
    }

    public function getTotalAfterDiscount () {

        return $this->totalFeesAfterDiscount;
    }

    public function setReceiptDetails($receiptDetailsString){
        
        array_push($this->receiptDetails , $receiptDetailsString);
    }

    public function getReceiptDetails(){
        
        return $this->receiptDetails;
    }

    public static function tearDown(){

        $cls = static::class;
        self::$instances[$cls] = NULL;

    }

}

