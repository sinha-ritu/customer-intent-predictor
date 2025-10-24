<?php
/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
 */
declare(strict_types=1);

namespace Vaimo\IntentPredictor\Controller\Adminhtml\Intent;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    public function __construct(
        Action\Context $context,
        private readonly PageFactory $resultPageFactory,
    ){
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Vaimo_IntentPredictor::menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Intent Predictor Analytics'));
        return $resultPage;
    }
}
