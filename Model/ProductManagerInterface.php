<?php

namespace MQM\ProductBundle\Model;

use MQM\ProductBundle\Model\ProductInterface;
use MQM\PaginationBundle\Pagination\PaginationInterface;
use MQM\SortBundle\Sort\SortManagerInterface;

interface ProductManagerInterface
{    
    const RECENT_MAX_RESULTS = 10;
    const RELATED_MAX_RESULTS = 5;
    
    /**
     * @return ProductInterface 
     */
    public function createProduct();
    
    /**
     *
     * @param ProductInterface $product
     * @param boolean $andFlush 
     */
    public function saveProduct(ProductInterface $product, $andFlush = true);
    
    /**
     *
     * @param ProductInterface $product
     * @param boolean $andFlush 
     */
    public function deleteProduct(ProductInterface $product, $andFlush = true);
    
    /**
     * @return ProductManagerInterface
     */
    public function flush();
    
    /**
     * @param array $criteria
     * @return ProductInterface 
     */
    public function findProductBy(array $criteria);
    
    /**
     * @return array 
     */
    public function findProducts(PaginationInterface $pagination = null);
    
    /**
     * @return array
     */
    public function findProductsByCategoryId($categoryId, SortManagerInterface $sortManager, PaginationInterface $pagination = null);
    
    /**
     * @return array
     */
    public function findProductsByBrandId($brandId, SortManagerInterface $sortManager, PaginationInterface $pagination = null);
    
    /**
     * @return array
     */
    public function findRecentProducts($maxResults = self::RECENT_MAX_RESULTS);
    
    /**
     * @return array
     */
    public function findRelatedProductsByProductId($productId, $maxResults = self::RELATED_MAX_RESULTS);
    
    /**
     * @return array
     */
    public function findProductsByMultiField($word, $searchMode, SortManagerInterface $sortManager, PaginationInterface $pagination = null);
}