<?php

namespace MQM\ProductBundle\Test\Product;

use MQM\ProductBundle\Product\ProductInterface;
use MQM\ProductBundle\Model\ProductManagerInterface;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\AppKernel;

class ProductManagerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{   
    protected $_container;
    private $productManager;

    public function __construct()
    {
        parent::__construct();
        
        $client = static::createClient();
        $container = $client->getContainer();
        $this->_container = $container;  
    }
    
    protected function setUp()
    {
        $this->productManager = $this->get('mqm_product.product_manager');
    }

    protected function tearDown()
    {
        $this->resetProducts();
    }

    protected function get($service)
    {
        return $this->_container->get($service);
    }
    
    public function testGetAssertManager()
    {
        $this->assertNotNull($this->productManager);
    }
    
    private function resetProducts()
    {
        $categories = $this->productManager->findProducts();
        foreach ($categories as $product) {
            $this->productManager->deleteProduct($product, false);
        }
        $this->productManager->flush();
    }
}
