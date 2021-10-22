<?php


Interface CartModelInterface {

    public static function getInstance();

    public function setProducts  ( $products );

    public function getProducts  ();

    public function setSubTotal ($subTotal);

    public function getSubTotal();

    public function setVatTotal ($vatTotal);

    public function getVatTotal();

    public function setTotalShippingFees ($shippingTotal);

    public function getTotalShippingFees ();

    public function setTotalAfterDiscount ($totalFeesAfterDiscount);

    public function getTotalAfterDiscount ();

    public function setReceiptDetails($receiptDetailsString);

    public function getReceiptDetails();

    public static function tearDown();

}

