<?php
/**
 * Copyright © 2025 Ritu Sinha
 *
 * This source code is licensed under the MIT license
 * that is bundled with this package in the file LICENSE.
 *
 * You are free to use, modify, and distribute this software
 * in accordance with the terms of the MIT License.
 */

declare(strict_types=1);

namespace SinhaR\IntentPredictor\Controller\Adminhtml\Intent;

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
        $resultPage->setActiveMenu('SinhaR_IntentPredictor::menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Intent Predictor Analytics'));
        return $resultPage;
    }
}
