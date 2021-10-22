<?php

 /**
 * CartController is used to handel input from view {index.php} 
 * by creating objects of model Cart , apply services and return 
 * results back to the view implementing MVC
 */
require(__DIR__.'/../Model/Factory.php');
require(__DIR__.'/../Model/ShippingFees/ShippingFeesFactory.php');
require(__DIR__.'/../Model/Product/ProductFactory.php');
require(__DIR__.'/../Model/Cart/CartFactory.php');
require(__DIR__.'/../../config/dbJson.php');
require(__DIR__.'/../../config/constants.php');
require(__DIR__.'/../Service/Discount/Contract/DiscountContractInterface.php');
require(__DIR__.'/../Service/Discount/Discount.php');
require(__DIR__.'/../Service/Discount/Provider/StrategyA.php');
require(__DIR__.'/../Service/Discount/Provider/StrategyB.php');
require(__DIR__.'/../Service/Discount/Provider/StrategyC.php');

class CartController {

    private $products;
    private $cart;

    public function __construct($productsNamesArray) { 

        $cartFactory = new CartFactory();
        $this->cart = $cartFactory->getObject();
        $this->products = $this->manipulateCart($productsNamesArray);
    }

    public function calculateSubTotal () {
        
        $subTotal = 0;

        foreach ($this->products as $product){
            $subTotal += $product->getItemPrice();
        }
        $this->cart->setSubTotal($subTotal);
        $this->cart->setReceiptDetails(__SUBTOTAL_TEXT__.__CURRUNCY__.$subTotal);
        return $this->cart->getSubTotal();
    }


    public function calculateTotalVat ()  {

        $vatTotal = 0;
        
        foreach ($this->products as $product){
            $vatTotal += $product->getItemVat();
        }
        $this->cart->setVatTotal($vatTotal);
        $this->cart->setReceiptDetails(__VAT_TEXT__.__CURRUNCY__.$vatTotal);
        return $this->cart->getVatTotal();
    }

    public function calculateTotalShippingFees () {

        $shippingTotal = 0;
        
        foreach ($this->products as $product){
            $shippingTotal += $product->getShippingFeesPerTotalWeight();
        }
        $this->cart->setTotalShippingFees($shippingTotal);
        $this->cart->setReceiptDetails(__SHIPPING_TEXT__.__CURRUNCY__.$shippingTotal);
        return $this->cart->getTotalShippingFees();
    }


    public function calculateTotalAfterDiscount () {

        $strategies = unserialize (__DISCOUNT_STRATEGIES_CLASSES__);
        $strategiesText = unserialize (__DISCOUNT_STRATEGIES_TEXT__);
        $strategiesValues = unserialize (__DISCOUNT_STRATEGIES_VALUES__);
        $discount = new Discount();
        $this->cart->setSubTotal($this->calculateSubTotal());
        $this->cart->setTotalShippingFees($this->calculateTotalShippingFees());
        $this->cart->setVatTotal($this->calculateTotalVat());
        $feesBeforeDiscount = $this->cart->getSubTotal() + $this->cart->getVatTotal() + $this->cart->getTotalShippingFees();
        $feesAfterDiscount = 0;


        for ($i=0; $i < count($strategies); $i++) { 
           
            $class = $strategies[$i];
            $strategyObject = new $class( $strategiesText[$i] , $strategiesValues[$i] );
            $discount->setStrategy($strategyObject);
            if( $i == 0 ){
                $feesAfterDiscount = $discount->calculateTotalDiscount( $feesBeforeDiscount );
            }else{
                $feesAfterDiscount = $discount->calculateTotalDiscount( $feesAfterDiscount );
            }

        }
        $this->cart->setTotalAfterDiscount($feesAfterDiscount);
        $this->cart->setReceiptDetails(__TOTAL_TEXT__.__CURRUNCY__.$feesAfterDiscount);
        return $this->cart->getTotalAfterDiscount();

    }

    public function manipulateCart($productsNamesArray) {

        $allProducts = __PRODUCTS__;
        $allShippingFees = __SHIPPINGFEES__;
        $productsObjectsArray = array();

        for ($i=0; $i < count($productsNamesArray); $i++) { 
            foreach($allProducts as $productJson) {
                if( $productJson['name'] == $productsNamesArray[$i] ){
                    $shippingFeesId = $productJson['shippingFeesId'];
                    $shippingFees;
                    foreach($allShippingFees as $item) { 
                        if($item['id'] == $shippingFeesId) {
                            $shippingFeesFactory = new ShippingFeesFactory($item['id'] , $item['country'] , $item['rate']);
                            $shippingFees = $shippingFeesFactory->getObject();

                        }
                    }
                    $productFactory = new ProductFactory( $productJson['id'] , $productJson['name'] , $shippingFees , $productJson['price'] , $productJson['weight'] , __VAT_RATIO__);
                    $product = $productFactory->getObject();
                    array_push($productsObjectsArray , $product);
                }
                
            }
        }
        $this->cart->setProducts($productsObjectsArray);
        return $productsObjectsArray;
    } 


    public function printReceipt() {
        $receiptDetails = $this->cart->getReceiptDetails();
        for ($i=0; $i < count($receiptDetails); $i++) { 
            echo $receiptDetails[$i];
            echo "\n";
        }
    }
}