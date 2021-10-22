<?php

use PHPUnit\Framework\TestCase;

require(__DIR__.'/../../../src/Exception/NonexistingProductException.php');
require(__DIR__.'/../../../src/Exception/UndefinedInputException.php');
require(__DIR__.'/../../../src/Exception/WrongCommandFormatException.php');


class CLIExceptionTest extends TestCase {

    
    
    public function testUndefinedInputException()
    {

        $this->expectException(Exception::class);  
        $this->expectException(UndefinedInputException::class);  
        $this->expectExceptionMessage("\nUndefined Input Please Type 'exit' or 'continue'\n");
 
        throw new UndefinedInputException();

    }

    public function testWrongCommandFormatException()
    {

        $this->expectException(Exception::class);  
        $this->expectException(WrongCommandFormatException::class);  
        $this->expectExceptionMessage("\nWrong Command Format , The Right Command Would Be Like\ncreateCart --product='T-shirt' --product='Blouse' --product='Pants' --product='Shoes' --product='Jacket'\n");
 
        throw new WrongCommandFormatException();

    }

    public function testNonexistingProductException()
    {

        $this->expectException(Exception::class);  
        $this->expectException(NonexistingProductException::class);  
        $this->expectExceptionMessage("\nYou've Input a Product That Doesnot Exists\nOur Product Are : T-shirt / Blouse / Pants / Sweatpants / Jacket / Shoes\nPlease Use Exact The Same Names With The Same Capital and Small Letters and Special Characters\n\n");
 
        throw new NonexistingProductException();

    }
}