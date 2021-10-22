<?php

// ----------------------------Comment To Run Testing For All------------------------------------
require(__DIR__.'/src/Controller/CartController.php');
require(__DIR__.'/src/Exception/UndefinedInputException.php');
require(__DIR__.'/src/Exception/NonexistingProductException.php');
require(__DIR__.'/src/Exception/WrongCommandFormatException.php');
// ----------------------------Comment To Run Testing For All------------------------------------


function start () {
    $cli = CLI::getInstance();
    $cli->printIntro();
    $cli->main( '' , '' );
}

class CLI{

    private static $instances;   

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


    public function printIntro(){
        echo "\n\n";
        echo "This program accepts a list of products, outputs the detailed invoice of the subtotal (sum of items prices), shipping fees, VAT, and discounts if applicable\n\n";
        echo "To use the program input your cart products using this command\n";
        echo "createCart --product='T-shirt' --product='Blouse' --product='Pants' --product='Shoes' --product='Jacket'\n\n";
        echo "To exit type 'exit' then press enter\n";
        echo "To continue type 'continue' then press enter\n\n";
    }


    public function main( $userInputText , $state , $isTesting = false ) {

        if(!$isTesting) $handle = fopen ("php://stdin","r");

        switch( $state ) {
            case 'UndefinedInputExceptionDidSucceed':
                $regex_pattern = "/^createCart( --product='[a-zA-Z0-9_.-]*')+$/";
                    try{
                        echo "\nPlease Input Your Products\n\n";
                        if(trim($userInputText) == '') $userInputText = fgets($handle);

                        $oldUserInputText = $userInputText;
                        $userInputTextArray = preg_grep($regex_pattern, explode("\n", $userInputText));
                        $inputProductsNamesArray = array();
    
                        if(count($userInputTextArray) > 0) {
                            CLI::main( $userInputTextArray[0] , 'WrongCommandFormatExceptionDidSucceed' );
                        } else {
                            throw new WrongCommandFormatException();
                        }
                    } catch(WrongCommandFormatException $e) {
                        if($isTesting)  return $e;
                        echo $e->getMessage();
                        CLI::main( '' , 'UndefinedInputExceptionDidSucceed' );
                    }
            break;

            
            case 'WrongCommandFormatExceptionDidSucceed':
                $allProductsNamesArray = array();
                $oldUserInputText = $userInputText;
                $inputProductsNamesArray = explode(" ",$userInputText);
                for($i = 1; $i < count($inputProductsNamesArray); $i++) {
                    $inputProductsNamesArray[$i] = explode("--product='",$inputProductsNamesArray[$i])[1];
                    $inputProductsNamesArray[$i] = substr($inputProductsNamesArray[$i], 0, -1);
                }
                try{
                    $allProducts = __PRODUCTS__;
                    $nonExistentProducts = 0;

                    foreach($allProducts as $productJson) {
                        array_push($allProductsNamesArray , $productJson['name']);
                    }
                
                    for ($i=1; $i < count($inputProductsNamesArray); $i++) {                             
                        if(!in_array($inputProductsNamesArray[$i], $allProductsNamesArray)) {
                            $nonExistentProducts++;
                        }
                    }
                    if($nonExistentProducts > 0){
                        throw new NonexistingProductException();
                    }else{
                        CLI::main( $inputProductsNamesArray , 'NonexistingProductExceptionDidSucceed' );
                    }
                } catch ( NonexistingProductException $e ){
                    if($isTesting)  return $e;
                    echo $e->getMessage();
                    CLI::main( '' , 'UndefinedInputExceptionDidSucceed' );
                }
            break;


            case 'NonexistingProductExceptionDidSucceed':
                $cartController = new CartController($userInputText);
                $cartController->calculateTotalAfterDiscount();
                $cartController->printReceipt();
                echo "\n";
                echo "Thank you \n";
                fclose($handle);  
            break;


            default: 
                try {
                    if(trim($userInputText) == '') $userInputText = fgets($handle);

                    if(trim($userInputText) == 'exit') {
                        echo "ABORTING!\n";
                        echo "\n";
                        echo "Thank you \n";
                        fclose($handle);                    
                    } else if(trim($userInputText) == 'continue') {
                        CLI::main( '' , 'UndefinedInputExceptionDidSucceed' );
                    } else {
                        throw new UndefinedInputException();
                    }
                } catch(UndefinedInputException $e) {
                    if($isTesting)  return $e;
                    echo $e->getMessage();
                    CLI::main( '' , '' );
                }
        }
    }
}

?>