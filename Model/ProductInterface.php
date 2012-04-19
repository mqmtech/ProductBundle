<?php

namespace MQM\ProductBundle\Model;

use MQM\BrandBundle\Model\BrandInterface;
use MQM\ImageBundle\Model\ImageInterface;
use MQM\CategoryBundle\Model\CategoryInterface;
use MQM\PricingBundle\Model\PriceRule\PriceRuleInterface;

interface ProductInterface
{
    /**
     *
     * @return TimeDiscountRule 
     */
    public function getDiscountRule();
             
    /**
     *
     * @param TimeDiscountRule $discountRule 
     */
    public function setDiscountRule($discountRule);
    
    /**
     * @return float $discountRule
     */
    public function getDiscount();

    /**
     * discountRule parameter between 0 and 100 %
     * 
     * @param float $discountRule
     */
    public function setDiscount($discountRule);
    
    /**
     * @return PriceRuleInterface 
     */
    public function getPriceRule();

    /**
     * @param PriceRuleInterface $priceRule 
     */
    public function setPriceRule(PriceRuleInterface $priceRule);

    /**
     * @return BrandInterface
     */
    public function getBrand();

    /**
     * @param BrandInterface $brand
     */
    public function setBrand(BrandInterface $brand);

    /**
     * @return ImageInterface
     */
    public function getimage();

    /**
     * @param ImageInterface $image
     */
    public function setimage(ImageInterface $image);
    
    /**
     * @return ImageInterface
     */
    public function getSecondImage();

    /**
     * @param ImageInterface $image
     */
    public function setSecondImage(ImageInterface $image);
    
      /**
     * @return ImageInterface
     */
    public function getThirdImage();

    /**
     * @param ImageInterface $image
     */
    public function setThirdImage(ImageInterface $image);
      /**
     * @return ImageInterface
     */
    public function getFourthImage();

    /**
     * @param ImageInterface $image
     */
    public function setFourthImage(ImageInterface $image);
    
    /**
     * @return CategoryInterface
     */
    public function getcategory();

    /**
     * @param CategoryInterface $category
     */
    public function setcategory(CategoryInterface $category);

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId();
    
     /**
     * Set id
     *
     * @param integer $id
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string 
     */
    public function getName();

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription();

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt);

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt();

    /**
     * Set modifiedAt
     *
     * @param datetime $modifiedAt
     */
    public function setModifiedAt($modifiedAt);

    /**
     * Get modifiedAt
     *
     * @return datetime 
     */
    public function getModifiedAt();

    /**
     * Set isFeatured
     *
     * @param boolean $isFeatured
     */
    public function setIsFeatured($isFeatured);

    /**
     * Get isFeatured
     *
     * @return boolean 
     */
    public function getIsFeatured();

    /**
     * Set isEnabled
     *
     * @param boolean $isEnabled
     */
    public function setIsEnabled($isEnabled);

    /**
     * Get isEnabled
     *
     * @return boolean 
     */
    public function getIsEnabled();

    /**
     * Set stock
     *
     * @param float $stock
     */
    public function setStock($stock);

    /**
     * Get stock
     *
     * @return float 
     */
    public function getStock();

    /**
     * Set weight
     *
     * @param float $weight
     */
    public function setWeight($weight);

    /**
     * Get weight
     *
     * @return float 
     */
    public function getWeight();

    /**
     * Set sku
     *
     * @param string $sku
     */
    public function setSku($sku);

    /**
     * Get sku
     *
     * @return string 
     */
    public function getSku();

    /**
     * Set basePrice
     *
     * @param float $basePrice
     */
    public function setBasePrice($basePrice);

    /**
     * Get basePrice
     *
     * @return float 
     */
    public function getBasePrice();
       
    /**
     *
     * @return string
     */
    public function getTag();

    /**
     *
     * @param string $tag 
     */
    public function setTag($tag);

    /**
     *
     * @return string
     */
    public function getSecondTag();

    /**
     *
     * @param string $secondTag 
     */
    public function setSecondTag($secondTag);

    /**
     *
     * @return string
     */
    public function getThirdTag();

    /**
     *
     * @param string $thirdTag 
     */
    public function setThirdTag($thirdTag);

    /**
     *
     * @return string 
     */
    public function getFourthTag();

    /**
     *
     * @param string $fourthTag 
     */
    public function setFourthTag($fourthTag);             
}
