<?php

namespace Vendor\CustomAttribute\Plugin\Checkout;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Vendor\CustomAttribute\Helper\Data as CustomAttributeHelper;

class CartItemPlugin
{
    protected $productRepository;
    protected $customAttributeHelper;

    public function __construct(ProductRepositoryInterface $productRepository,
                                CustomAttributeHelper $customAttributeHelper
    )
    {
        $this->productRepository = $productRepository;
        $this->customAttributeHelper = $customAttributeHelper;

    }

    public function afterGetItemData($subject, $result, CartItemInterface $item)
    {
        if (!$this->customAttributeHelper->isCustomAttributeEnabled())
        {
            $result['product_custom_text_attribute'] = false;
            return $result;
        }
        $productId = $item->getProduct()->getId();
        $product = $this->productRepository->getById($productId);
        $customAttributeValue = $product->getData('custom_text_attribute');

        if ($customAttributeValue) {
            $result['product_custom_text_attribute'] = $customAttributeValue;
        }

        return $result;
    }
}
