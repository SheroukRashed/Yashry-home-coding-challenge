<?php

Interface ProductModelInterface
{
   
    public function getShippingFeesPerTotalWeight();

    public function setShippingFees($shippingFees);

    public function getShippingFees();

    public function setItemType($itemType);

    public function getItemType();

    public function setItemPrice($itemPrice);

    public function getItemPrice();

    public function setItemVat($vat);

    public function getItemVat();

    public function setItemWeight($itemWeight);

    public function getItemWeight();

}