<?php

namespace MQM\ProductBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use MQM\ProductBundle\Model\ProductManagerInterface;
use MQM\ProductBundle\Model\ProductInterface;

class RegistrationFormHandler
{
    protected $request;
    protected $productManager;
    protected $form;
    protected $mailer;

    public function __construct(Form $form, Request $request, ProductManagerInterface $productManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->productManager = $productManager;
    }

    public function process()
    {
        $product = $this->productManager->createProduct();
        $this->form->setData($product);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bindRequest($this->request);

            if ($this->form->isValid()) {
                $this->onSuccess($product);

                return true;
            }
        }

        return false;
    }

    protected function onSuccess(ProductInterface $product)
    {
        $this->productManager->saveProduct($product, true);
    }
}