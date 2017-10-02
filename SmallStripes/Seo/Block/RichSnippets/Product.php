<?php

namespace SmallStripes\Seo\Block\RichSnippets;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;

class Product extends Template
{
    protected $registry;
    protected $_stockItemRepository;

    public function __construct(
        Context $context,
        Registry $registry,
        StockItemRepository $stockItemRepository,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->_stockItemRepository = $stockItemRepository;
        parent::__construct($context, $data);
    }

    public function getProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function getSku()
    {
        return $this->getProduct()->getSku();
    }

    public function getProductName()
    {
        return $this->getProduct()->getName();
    }

    public function getDescription()
    {
        return htmlspecialchars(trim(strip_tags($this->getProduct()->getShortDescription())));
    }

    public function getPriceCurrency()
    {
        return $this->_storeManager->getStore()->getCurrentCurrencyCode();
    }

    public function getPrice()
    {
        return round($this->getProduct()->getPrice(), 2);
    }

    public function getAvailability()
    {
        $productId = (int)$this->getProduct()->getId();
        $_productStock = $this->_stockItemRepository->get($productId);
        if ($_productStock->getIsInStock()) {
            return 'http://schema.org/InStock';
        }
        return 'http://schema.org/OutOfStock';
    }

    public function getItemCondition()
    {
        return 'http://schema.org/NewCondition';
    }

    public function getPriceValidUntil()
    {
        return $this->getProduct()->getSpecialToDate();
    }

    public function getBrandName()
    {
        $optionId = $this->getProduct()->getManufacturer();
        $attr = $this->getProduct()->getResource()->getAttribute('manufacturer');
        if ($attr->usesSource()) {
            return $attr->getSource()->getOptionText($optionId);
        }
        return "";
    }

    public function haveImages()
    {
        return true;
    }

    public function getImages()
    {
        $images = array();
        foreach ($this->getProduct()->getMediaGalleryImages() as $image) {
            $images[] = '"' . $image->getData('large_image_url') . '"';
        }
        return $images;
    }
}
