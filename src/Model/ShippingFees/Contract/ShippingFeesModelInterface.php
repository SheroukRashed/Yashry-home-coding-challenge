<?php

interface ShippingFeesModelInterface
{
    public function setCountry($country);

    public function getCountry();

    public function setRate($rate);

    public function getRate();
}