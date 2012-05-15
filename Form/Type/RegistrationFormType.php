<?php

namespace MQM\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\PersistentCollection;
use MQM\CategoryBundle\Model\CategoryManagerInterface;
use MQM\ShopBundle\Form\Type\PriceRuleType;
use MQM\ShopBundle\Form\Type\ImageType;
use MQM\ShopBundle\Form\Type\DiscountByProductRuleType;

class RegistrationFormType extends AbstractType
{
    private $class;
    private $categoryManager;

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
            ->add('name', null, array(
                'label' => 'add_titulo',
                'max_length' => '70'
            ))
            ->add('description')
            ->add('sku', null, array(
                'label' => 'add_ref'
            ))
            ->add('priceRule', new PriceRuleType())
            ->add('discountRule', new DiscountByProductRuleType())
            ->add('category', 'entity', array(
             'class' => 'MQM\CategoryBundle\Entity\Category',
             'empty_value' => 'Categorias...',
             'required' => true,
             'label' => 'Categoria',
             'choices' => $this->buildOrdenedCategoriesChoice()
              ))
            ->add('image', new ImageType(), array(
                'required' => false,
                'label' => ' ',
            ))            
            ->add('secondImage', new ImageType(), array(
                'label' => ' '
            ))            
            ->add('thirdImage', new ImageType(), array(
                'label' => ' '
            ))
            ->add('fourthImage', new ImageType(), array(
                'label' => ' '
            ))            
            ->add('tag', null, array(
                'label' => ' add_tags'
            ))
            ->add('secondTag', null, array(
                'label' => ' add_tags'
            ))
            ->add('thirdTag', null, array(
                'label' => ' add_tags'
            ))
            ->add('fourthTag', null, array(
                'label' => ' add_tags'
            ))            
            ->add('brand', 'entity', array(
                'empty_value' => 'Marcas...',
                'class' => 'MQM\BrandBundle\Entity\Brand',
                'required' => true,
                'label' => 'Marca'
              ));
    }    

    public function buildOrdenedCategoriesChoice(PersistentCollection $categories=null, array &$categoriesChoice = null)
    {        
        if ($categoriesChoice == null) {
            $categoriesChoice = array();
        }
        
        if ($categories == null) {
            $categories = (array) $this->categoryManager->findAllFamilies();
        }
        
        foreach ($categories as $category) {
            $categoriesChoice[$category->getId()] = $category;
            $subCategories = $category->getCategories();
            if ($subCategories != null) {
               $this->buildOrdenedCategoriesChoice($subCategories, $categoriesChoice);
            }
        }
        
        return $categoriesChoice;
    }
    
    public function getName()
    {
        return 'mqm_shop_form_type_product';
    }
        
    public function getDefaultOptions()
    {
        return array(
            'data_class' => 'MQM\ProductBundle\Entity\Product',
            'validation_groups' => 'Registration',
        );
    }

    public function __construct($class, CategoryManagerInterface $categoryManager)
    {
        $this->class = $class;
        $this->categoryManager = $categoryManager;
    }
}
