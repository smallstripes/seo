<?php

namespace SmallStripes\Seo\Block\RichSnippets;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Theme\Block\Html\Header\Logo;
use Magento\Store\Model\Information;

class Organization extends Template
{
    protected $_logo;
    protected $_storeInfo;

    public function __construct(
        Context $context,
        Logo $logo,
        Information $storeInfo,
        array $data = []
    ) {
        $this->_logo = $logo;
        $this->_storeInfo = $storeInfo;
        parent::__construct($context, $data);
    }

    public function getLogo()
    {
        return $this->_logo->getLogoSrc();
    }

    public function getTelephone()
    {
        return $this->_scopeConfig->getValue('general/store_information/phone',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
