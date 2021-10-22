<?php

use PHPUnit\Framework\TestCase;

require(__DIR__.'/../../index.php');


class indexTest extends TestCase {

    private $cli;

    protected function setUp(): void
    {
        $this->cli = CLI::getInstance();
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('CLI', $this->cli);
    }

    public function testPrintIntro()
    {
        $intro = "\n\n".
        "This program accepts a list of products, outputs the detailed invoice of the subtotal (sum of items prices), shipping fees, VAT, and discounts if applicable\n\n".
        "To use the program input your cart products using this command\n".
        "createCart --product='T-shirt' --product='Blouse' --product='Pants' --product='Shoes' --product='Jacket'\n\n".
        "To exit type 'exit' then press enter\n".
        "To continue type 'continue' then press enter\n\n";

        $this->expectOutputString($intro);
        $this->cli->printIntro();
       
    }

    public function testMain(){

        $expectException = $this->cli->main('any' , '', true);
        $this->assertInstanceOf('UndefinedInputException', $expectException);

        $expectException = $this->cli->main("createCart --product='T-shirt' --product='Blouse' --product='Pants' --product='Sh" , 'UndefinedInputExceptionDidSucceed', true);
        $this->assertInstanceOf('WrongCommandFormatException', $expectException);

        $expectException = $this->cli->main("createCart --product='T-shirt' --product='Blouse' --product='Pants' --product='Camera'" , 'WrongCommandFormatExceptionDidSucceed', true);
        $this->assertInstanceOf('NonexistingProductException', $expectException);

    }



}