<?php

namespace MQM\ProductBundle\Entity;

use Doctrine\ORM\EntityRepository;
use MQM\ProductBundle\Model\ProductInterface;
use MQM\PaginationBundle\Pagination\PaginationInterface;
use MQM\SortBundle\Sort\SortManagerInterface;

class ProductRepository extends EntityRepository
{
    const RECENT_ORDER_BY = 'DESC';
    
    public function findAll(PaginationInterface $pagination = null)
    {
        $em = $this->getEntityManager();
        $sql = "SELECT p from MQMProductBundle:Product p";        
        $q = $em->createQuery($sql);
        if ($pagination) {
            $q = $pagination->paginateQuery($q);
        }
        
        return $q->getResult();
    }
    
    /**
     *
     * @param type $categoryId
     * @param array $sortManager [field,mode]
     * @return ProductInterface 
     */
    public function findProductsByCategoryId($categoryId, SortManagerInterface $sortManager, PaginationInterface $pagination = null)
    {
        $sql = "SELECT p from MQMProductBundle:Product p JOIN p.category c WHERE c.id = '".$categoryId."' ";
        if ($sortManager) {
            $sql .= $sortManager->sortQuery($sql, 'p'); 
        }
        $em = $this->getEntityManager();        
        $q = $em->createQuery($sql);
        if ($pagination) {
            $q = $pagination->paginateQuery($q);
        }
        
        $products = $q->getResult();
        
        return $products;
    }
    
    /**
     * list of products
     * 
     * return array
     */
    public function findProductsByBrandId($brandId, SortManagerInterface $sortManager,  PaginationInterface $pagination = null)
    {
        $sql = "SELECT p from MQMProductBundle:Product p JOIN p.brand b WHERE b.id = '".$brandId."' ";
        if ($sortManager) {
            $sql .= $sortManager->sortQuery($sql, 'p'); 
        }
        $em = $this->getEntityManager();
        $q = $em->createQuery($sql);
        if ($pagination) 
            $q = $pagination->paginateQuery ($q);
        $products = $q->getResult();
        
        return $products;
    }
    
    public function findRecentProducts($maxResults)
    {
        $em = $this->getEntityManager();
        $q = $em->createQuery("SELECT p from MQMProductBundle:Product p ORDER BY p.createdAt ".self::RECENT_ORDER_BY);
        $q->setMaxResults($maxResults);
        $products = $q->getResult();

        return $products;
    }
    
    public function findRelatedProductsByProductId($productId, $maxResults)
    {
        $product = $this->find($productId);        
        $tag = $product->getTag();
        $secondTag = $product->getSecondTag();
        $thirdTag = $product->getThirdTag();
        $fourthTag = $product->getFourthTag();
        
        $sql = "SELECT p FROM MQMProductBundle:Product p WHERE p.id <> '".$productId."'";
        
        $sqlTag = $this->tagEqualHelper($tag);
        $sqlSecondTag = $this->tagEqualHelper($secondTag);
        $sqlThirdTag = $this->tagEqualHelper($thirdTag);
        $sqlFourthTag = $this->tagEqualHelper($fourthTag);
        
        $sql = $sql . " AND (" .$sqlTag ." OR " .$sqlSecondTag ." OR " .$sqlThirdTag ." OR " .$sqlFourthTag . ")";
        
        $em = $this->getEntityManager();
        $q = $em->createQuery($sql);
        $q->setMaxResults($maxResults);
        $products = $q->getResult();
        
        return $products;
    }
    
    /**
     *
     * @param type $word
     * @param type $mode
     * @param QueryPaginationInterface $pagination
     * @param type $sortManager
     * @return array 
     */
    public function findProductsByMultiField($word, $mode, SortManagerInterface $sortManager, PaginationInterface $pagination = null)
    {
        //Name and description search
        $query = " WHERE p." . "name" . " LIKE '%" . $word . "%'";
        $query .= " $mode p." . "description" . " LIKE '%" . $word . "%'";        
        //Tag search
        $query .= " $mode p." . "tag" . " LIKE '%" . $word . "%'";
        $query .= " $mode p." . "secondTag" . " LIKE '%" . $word . "%'";
        $query .= " $mode p." . "thirdTag" . " LIKE '%" . $word . "%'";
        $query .= " $mode p." . "fourthTag" . " LIKE '%" . $word . "%'";        
        //Sku Search
        $query .= " $mode p." . "sku" . " LIKE '%" . $word . "%'";        
        //Brand search
        $query .= " $mode b." . "name" . " LIKE '%" . $word . "%'";
        $query .= " $mode b." . "description" . " LIKE '%" . $word . "%'";
        
        if ($sortManager) {
            $query = $sortManager->sortQuery($query, 'p');     
        }
        $em = $this->getEntityManager();
        $q = $em->createQuery("SELECT p from MQMProductBundle:Product p JOIN p.brand b" . $query);        
        if ($pagination) {
            $q = $pagination->paginateQuery($q);
        }
        $products = $q->getResult();        
        
        return $products;
    }
    
    private function tagEqualHelper($tag)
    {
        $sql = "";
        for ($index = 0; $index < 4; $index++) {
            $sql = "p.tag LIKE '%".$tag."%' OR " . 
                   "p.secondTag LIKE '%".$tag."%' OR " . 
                   "p.thirdTag LIKE '%".$tag."%' OR " . 
                   "p.fourthTag LIKE '%".$tag."%'";
        }
        
        return $sql;
    }
}