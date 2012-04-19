<?php

namespace MQM\ProductBundle\Entity;

use MQM\ProductBundle\Model\ProductManagerInterface;
use MQM\ProductBundle\Model\ProductFactoryInterface;
use MQM\ProductBundle\Model\ProductInterface;
use MQM\PricingBundle\Model\PriceRule\PriceRuleManagerInterface;
use MQM\PricingBundle\Model\DiscountRule\DiscountRuleManagerInterface;
use MQM\PaginationBundle\Pagination\PaginationInterface;
use MQM\SortBundle\Sort\SortManagerInterface;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ProductManager implements ProductManagerInterface
{
    private $factory;
    private $entityManager;
    private $repository;
    private $priceRuleManager;
    private $discountRuleManager;
   
    public function __construct(EntityManager $entityManager, ProductFactoryInterface $factory, PriceRuleManagerInterface $priceRuleManager, DiscountRuleManagerInterface $discountRuleManager)
    {
        $this->entityManager = $entityManager;
        $this->factory = $factory;
        $productClass = $factory->getProductClass();
        $this->repository = $entityManager->getRepository($productClass);
        $this->priceRuleManager = $priceRuleManager;
        $this->discountRuleManager = $discountRuleManager;
    }
    
    /**
     * {@inheritDoc}
     */
    public function createProduct()
    {
        $product = $this->getFactory()->createProduct();
        
        $priceRule = $this->priceRuleManager->createPriceRule();
        $priceRule->setProduct($product);
        $product->setPriceRule($priceRule);
        
        $discountRule = $this->discountRuleManager->createDiscountRule();
        $discountRule->setProduct($product);
        $product->setDiscountRule($discountRule);
        
        return $product;
    }
    
    /**
     * {@inheritDoc}
     */
    public function saveProduct(ProductInterface $product, $andFlush = true)
    {
        $this->getEntityManager()->persist($product);
        if ($andFlush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function deleteProduct(ProductInterface $product, $andFlush = true)
    {
        $this->getEntityManager()->remove($product);
        if ($andFlush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        $this->getEntityManager()->flush();
        
        return $this;
    }
    
    /**
     * 
     * {@inheritDoc}
     */
    public function findProductBy(array $criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function findProducts(PaginationInterface $pagination = null)
    {
        return $this->getRepository()->findAll($pagination);
    }
    
    /**
     * 
     * {@inheritDoc}
     */
    public function findProductsByMultiField($word, $searchMode, SortManagerInterface $sortManager, PaginationInterface $pagination = null)
    {
        return $this->getRepository()->findProductsByMultiField($word, $searchMode, $sortManager, $pagination);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function findProductsByBrandId($brandId, SortManagerInterface $sortManager, PaginationInterface $pagination = null)
    {
        return $this->getRepository()->findProductsByBrandId($brandId, $sortManager, $pagination);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function findProductsByCategoryId($categoryId, SortManagerInterface $sortManager, PaginationInterface $pagination = null)
    {
        return $this->getRepository()->findProductsByCategoryId($categoryId, $sortManager, $pagination);
    }
    
    /**
     * 
     * {@inheritDoc}
     */
    public function findRecentProducts($maxResults = self::RECENT_MAX_RESULTS)
    {
        return $this->getRepository()->findRecentProducts($maxResults);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function findRelatedProductsByProductId($productId, $maxResults = self::RELATED_MAX_RESULTS)
    {
        return $this->getRepository()->findRelatedProductsByProductId($productId, $maxResults);
    }

    /**
     *
     * @return ProductFactoryInterface
     */
    protected function getFactory()
    {
        return $this->factory;
    }

    /**
     *
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->repository;
    }
    
    /**
     *
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }
}