<?php

namespace MQM\ProductBundle\Entity;

use MQM\ProductBundle\Model\ProductFactoryInterface;

class ProductFactory implements ProductFactoryInterface
{
    private $productClass;

    
    public function __construct($productClass)
    {
        $this->productClass = $productClass;
    }
    
    /**
     * {@inheritDoc}
     */
    public function createProduct()
    {
        return new $this->productClass();
    }

    /**
     * {@inheritDoc}
     */
    public function getProductClass()
    {
        return $this->productClass;
    }
}


