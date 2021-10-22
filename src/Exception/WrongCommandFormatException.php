<?php

class WrongCommandFormatException extends Exception {

    protected $message;  //: String
    
    public function __construct( $message = "\nWrong Command Format , The Right Command Would Be Like\ncreateCart --product='T-shirt' --product='Blouse' --product='Pants' --product='Shoes' --product='Jacket'\nPlease Make Sure To Remove Unnecessary Spaces") {

        $this->message = $message;

    }
}