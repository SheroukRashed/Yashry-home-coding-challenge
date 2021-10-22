# Yashry-home-coding-challenge

## Description of the problem and solution: 
### The Problem:
Having a list of products, Need to calculate detailed invoice of the subtotal (sum of items prices), shipping fees, VAT, and discounts.
### The Solution:
Create a program accepts a list of products as input through CLI, outputs the detailed invoice of the subtotal (sum of items prices), shipping fees, VAT, and discounts, 
this program under make sutible calculations to decide weather to apply a group of discount strategies or not on this list of product.

## Whether the solution focuses on back-end, front-end or if it's full stack.
Mainly this program focuses on Backend structures.

## Reasoning behind your technical choices, including architectural
The program is build through group of design patterns that would offer sclability if needed in the future, Stick to SOLID principles and OO fundamentels
for example 

The usage of MVC to structure code files separetly.

In discount service part strategy design pattern was used so incase you want to add a new strategy in the future 
you only add one class that implements the strategy contarct interface and add the new class name in array kept in contstants.php file.

In Model Part I've used factory design patern for sclabilty so for example if you want to add a new type of products in the future that would maybe has different props 
you only create the new product class and implement the productModelInterface.

Moreover Singletone Design pattern is used with the cart model since for the one excution there is always only one cart.

Since it was not required to implement any persistent layer, this solution use array of products and shipping fees which are stored as json in constants found in dbJson.php

User Input Error Handling Exceptions are used.

## Used Libraries 
PhpUnit for testing.

## How to run the program
firstly run 
### php -r "require 'index.php'; start();"
then the program would ask weather to continue or exit, then type
### continue
after that you are required to add your product list, then you need to type a command looks like 
### createCart --product='T-shirt' --product='Blouse' --product='Pants' --product='Shoes' --product='Jacket'
----- In case you've entered a wrong command or non existing product the program print error to help you to correct your input. -----
