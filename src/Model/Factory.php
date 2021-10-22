<?php

abstract class Factory
{
    /**
     * The actual factory method. Note that it returns the abstract object.
     * This lets subclasses return any concrete object without breaking the
     * superclass' contract.
     */
    abstract public function getObject();

    
    
}