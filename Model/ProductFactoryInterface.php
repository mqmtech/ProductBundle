<?php

namespace MQM\ProductBundle\Model;

use MQM\ProductBundle\Model\ProductInterface;

interface ProductFactoryInterface
{
    /**
     * @return ProductInterface
     */
    public function createProduct();
    
    /**
     * @return string
     */
    public function getProductClass();
}


