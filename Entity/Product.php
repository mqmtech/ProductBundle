<?php

namespace MQM\ProductBundle\Entity;

use MQM\ProductBundle\Model\ProductInterface;
use MQM\BrandBundle\Model\BrandInterface;
use MQM\ImageBundle\Model\ImageInterface;
use MQM\CategoryBundle\Model\CategoryInterface;
use MQM\PricingBundle\Entity\DiscountRule\DiscountByProductRule;
use MQM\PricingBundle\Model\PriceRule\PriceRuleInterface;

use \DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table(name="shop_product")
 * @ORM\Entity(repositoryClass="MQM\ProductBundle\Entity\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Product implements ProductInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var datetime $modifiedAt
     *
     * @ORM\Column(name="modifiedAt", type="datetime", nullable=true)
     */
    private $modifiedAt;

    /**
     * @var boolean $isFeatured
     *
     * @ORM\Column(name="isFeatured", type="boolean", nullable=true)
     */
    private $isFeatured;

    /**
     * @var boolean $isEnabled
     *
     * @ORM\Column(name="isEnabled", type="boolean", nullable=true)
     */
    private $isEnabled;

    /**
     * @var float $stock
     *
     * @ORM\Column(name="stock", type="float", nullable=true)
     */
    private $stock;

    /**
     * @var float $weight
     *
     * @ORM\Column(name="weight", type="float", nullable=true)
     */
    private $weight;

    /**
     * @var string $sku
     *
     * @ORM\Column(name="sku", type="string", length=255, nullable=true)
     */
    private $sku;

    /**
     * @var float $basePrice
     *
     * @ORM\Column(name="basePrice", type="float", nullable=true)
     */
    private $basePrice;    
    
    /**
     * @var PriceRuleInterface $priceRule
     * 
     * @ORM\OneToOne(targetEntity="MQM\PricingBundle\Entity\PriceRule\PriceRule", mappedBy="product", cascade={"persist", "remove"}))
     */
    private $priceRule;
    
    /**
     * @var DiscountByProductRule $discountRule
     * 
     * @ORM\OneToOne(targetEntity="MQM\PricingBundle\Entity\DiscountRule\DiscountByProductRule", mappedBy="product", cascade={"persist", "remove"}))
     */
    private $discountRule;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="MQM\CategoryBundle\Entity\Category", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumn(name="categoryId", referencedColumnName="id", nullable=true)
     * 
     * @var CategoryInterface $category
     */
    private $category;
    
    /**
     * @Assert\Type(type="MQM\ImageBundle\Entity\Image")
     *
     *
     * @ORM\ManyToOne(targetEntity="MQM\ImageBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="imageId", referencedColumnName="id", nullable=true)
     *
     * @var ImageInterface $image
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="MQM\ImageBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="secondImageId", referencedColumnName="id", nullable=true)
     *
     * @var ImageInterface $secondImage
     */
    private $secondImage;

    /**
     * @ORM\ManyToOne(targetEntity="MQM\ImageBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="thirdImageId", referencedColumnName="id", nullable=true)
     *
     * @var ImageInterface $thirdImage
     */
    private $thirdImage;

    /**
     * @ORM\ManyToOne(targetEntity="MQM\ImageBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="fourthImageId", referencedColumnName="id", nullable=true)
     *
     * @var ImageInterface $fourthImage
     */
    private $fourthImage;

    /**
     * @ORM\ManyToOne(targetEntity="MQM\BrandBundle\Entity\Brand", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumn(name="brandId", referencedColumnName="id")
     *
     * @var BrandInterface $brand
     */
    private $brand;
    
     /**
     * @var string $tag
     *
     * @ORM\Column(name="tag", type="string", length=255, nullable=true)
     */
    private $tag;
    
    /**
     * @var string $secondTag
     *
     * @ORM\Column(name="secondTag", type="string", length=255, nullable=true)
     */
    private $secondTag;
    
    /**
     * @var string $thirdTag
     *
     * @ORM\Column(name="thirdTag", type="string", length=255, nullable=true)
     */
    private $thirdTag;
    
    /**
     * @var string $fourthTag
     *
     * @ORM\Column(name="fourthTag", type="string", length=255, nullable=true)
     */
    private $fourthTag;
    
    public function __construct() 
    {
        $this->createdAt = new DateTime();    
    }


    public function __toString() 
    {
       return '' . $this->getName();
    }

    /**
     * Invoked before the entity is updated.
     *
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->modifiedAt = new \DateTime();
    }
    
    function __clone()
    {
        $image = $this->image;
        if ($image) {
            $this->image = clone ($image);
        }
        
        $image = $this->secondImage;
        if ($image) {
            $this->secondImage = clone ($image);
        }
        
        $image = $this->thirdImage;
        if ($image) {
            $this->thirdImage = clone ($image);
        }
        
        $image = $this->fourthImage;
        if ($image) {
            $this->fourthImage = clone ($image);
        }
        
        if ($this->discountRule != null) {
            $this->discountRule = clone ($this->discountRule);
            $this->discountRule->setProduct($this);
        }        
        
        if ($this->priceRule != null) {
            $this->priceRule = clone ($this->priceRule);
            $this->priceRule->setProduct($this);
        }       
    }
    
    /**
     *
     * {@inheritDoc}
     */
    public function getPriceRule()
    {
        return $this->priceRule;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setPriceRule(PriceRuleInterface $priceRule)
    {
        $this->priceRule = $priceRule;
    }
         
    /**
     *
     * {@inheritDoc}
     */
    public function getDiscountRule()
    {
        return $this->discountRule;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setDiscountRule($discountRule)
    {
        $this->discountRule = $discountRule;
    }
    
    /**
     *
     * {@inheritDoc}
     */
    public function getDiscount()
    {
        return $this->discountRule;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setDiscount($discountRule)
    {
        $discountRule = (float) $discountRule;
        $this->discountRule = $discountRule;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setBrand(BrandInterface $brand)
    {
        $this->brand = $brand;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getimage()
    {
        return $this->image;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setimage(ImageInterface $image)
    {
        $this->image = $image;
    }
    
     /**
     *
     * {@inheritDoc}
     */
    public function getSecondImage()
    {
        return $this->secondImage;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setSecondImage(ImageInterface $image)
    {
        $this->secondImage = $image;
    }
    
     /**
     *
     * {@inheritDoc}
     */
    public function getThirdImage()
    {
        return $this->thirdImage;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setThirdImage(ImageInterface $image)
    {
        $this->thirdImage= $image;
    }
    
     /**
     *
     * {@inheritDoc}
     */
    public function getFourthImage()
    {
        return $this->fourthImage;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setFourthImage(ImageInterface $image)
    {
        $this->fourthImage= $image;
    }
    
    /**
     *
     * {@inheritDoc}
     */
    public function getcategory()
    {
        return $this->category;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setcategory(CategoryInterface $category)
    {
        $this->category= $category;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     *
     * {@inheritDoc}
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setIsFeatured($isFeatured)
    {
        $this->isFeatured = $isFeatured;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getIsFeatured()
    {
        return $this->isFeatured;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setBasePrice($basePrice)
    {
        $this->basePrice = $basePrice;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getBasePrice()
    {
        return $this->basePrice;
    }
       
    /**
     *
     * {@inheritDoc}
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setTag($tag)
    {
        $this->tag = strtolower($tag);
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getSecondTag()
    {
        return $this->secondTag;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setSecondTag($secondTag)
    {
        $this->secondTag = strtolower($secondTag);
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getThirdTag()
    {
        return $this->thirdTag;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setThirdTag($thirdTag)
    {
        $this->thirdTag = strtolower($thirdTag);
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getFourthTag()
    {
        return $this->fourthTag;
    }

    /**
     *
     * {@inheritDoc}
     */
    public function setFourthTag($fourthTag)
    {
        $this->fourthTag = strtolower($fourthTag);
    }
}
