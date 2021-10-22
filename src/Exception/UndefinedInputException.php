<?php

class UndefinedInputException extends Exception {

    protected $message;  //: String
    
    public function __construct( $message = "\nUndefined Input Please Type 'exit' or 'continue'\n") {

        $this->message = $message;

    }

}