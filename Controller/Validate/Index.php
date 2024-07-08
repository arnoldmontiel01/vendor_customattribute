<?php

namespace Vendor\CustomAttribute\Controller\Validate;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct(
            $context
        );
    }

    public function execute()
    {
        $params = $this->getRequest()->getParams();
            if (!isset($params['custom_text_attribute'])) {
                $this->messageManager->addErrorMessage(
                    __('The attribute can\'t be, empty')
                );
                return $this->resultRedirectFactory->create()->setRefererUrl();
            }
        if (strlen($params['custom_text_attribute'])<3) {
            $this->messageManager->addErrorMessage(
                __('Please enter at least 3 characters.')
            );
            return $this->resultRedirectFactory->create()->setRefererUrl();
        }

        $this->messageManager->addSuccessMessage(__(
            'The custom attribute was successfully validated.'
        ));
        return $this->resultRedirectFactory->create()->setRefererUrl();
    }

}
