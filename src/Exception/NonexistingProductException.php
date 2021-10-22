<?php


class NonexistingProductException extends Exception {

    protected $message;  //: String
    
    public function __construct( $message = "\nYou've Input a Product That Doesnot Exists\nOur Product Are : T-shirt / Blouse / Pants / Sweatpants / Jacket / Shoes\nPlease Use Exact The Same Names With The Same Capital and Small Letters and Special Characters\n\n") {

        $this->message = $message;

    }
    

}