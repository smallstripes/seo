<?php

namespace SmallStripes\Seo\Block\OpenGraph;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Catalog\Block\Product\ImageBuilder;

class Product extends Template
{
    protected $registry;
    protected $_imageBuilder;

    public function __construct(
        Context $context,
        Registry $registry,
        ImageBuilder $imageBuilder,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->_imageBuilder = $imageBuilder;
        parent::__construct($context, $data);
    }

    public function getProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function getTitle()
    {
        return $this->getProduct()->getName();
    }

    public function getImage()
    {
//        return null;
        $image = $this->_imageBuilder->setProduct($this->getProduct())->setImageId('product_page_main_image')->create();
        return $image->getImageUrl();
    }

    public function getProductUrl()
    {
        return $this->getProduct()->getUrlInStore();
    }

    public function getDescription()
    {
        return $this->getProduct()->getDescription();
    }

    public function getRetailerItemId()
    {
        return $this->getProduct()->getSku();
    }

    public function getSiteName()
    {
        return $this->_scopeConfig->getValue('general/store_information/name',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
//        return $this->getProduct()->getName();
    }

    public function showPrice()
    {
        return true;
    }

    public function getPriceAmount()
    {
        return $this->getProduct()->getFinalPrice();
    }

    public function getPriceCurrency()
    {
        return $this->_storeManager->getStore()->getCurrentCurrency()->getCode();
    }
}
