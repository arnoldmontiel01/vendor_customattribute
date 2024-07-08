<?php
namespace Vendor\CustomAttribute\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Registry;
use Vendor\CustomAttribute\Helper\Data as CustomAttributeHelper;

class CustomAttributeDisplay extends Template
{
    protected ProductRepositoryInterface $productRepository;
    protected Registry $registry;
    protected CustomAttributeHelper $customAttributeHelper;

    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        CustomAttributeHelper $customAttributeHelper,
        Registry $registry,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->customAttributeHelper = $customAttributeHelper;
        $this->registry = $registry;

        parent::__construct($context, $data);
    }

    public function getCustomAttributeValue()
    {
        $product = $this->registry->registry('current_product');
        if ($product && $product->getId()) {
            return $product->getCustomAttribute('custom_text_attribute')->getValue();
        }
        return '';
    }
    public function isCustomAttributeEnabled()
    {
        return (bool) $this->customAttributeHelper->isCustomAttributeEnabled();
    }
    public function getActionUrl():string
    {
        return $this->getUrl("customattribute/validate/index");
    }
}
