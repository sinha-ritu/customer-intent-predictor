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

namespace SinhaR\IntentPredictor\Controller\Intent;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Serialize\Serializer\Json as JsonHelper;
use Magento\Framework\Session\SessionManagerInterface;
use Psr\Log\LoggerInterface;
use SinhaR\IntentPredictor\Model\Scoring;

class Score extends Action
{
    public function __construct(
        Context                                  $context,
        private readonly JsonFactory             $resultJsonFactory,
        private readonly LoggerInterface         $logger,
        private readonly Scoring                 $scoring,
        private readonly JsonHelper               $serializer,
        private readonly SessionManagerInterface $sessionManager,
    ) {
        parent::__construct($context);
    }

    public function execute(): Json|ResultInterface|ResponseInterface
    {
        $result = $this->resultJsonFactory->create();
        $sessionId = $this->sessionManager->getSessionId();
        $customerId = method_exists($this->sessionManager, 'getCustomerId')
            ? $this->sessionManager->getCustomerId()
            : null;
        $data = $this->serializer->unserialize($this->getRequest()->getContent());
        $this->logger->error('data', $data);
        try {
            $response = $this->scoring->calculateScore($data, (string)$sessionId, (string)$customerId);
        } catch (\Exception $e) {
            return $result->setData(['error' => true, 'message' => $e->getMessage()]);
        }
        $this->logger->error('SCORE', [$response]);

        return $result->setData([
            'success' => true,
            'intent'  => $response['intent'],
            'score'   => $response['score'],
            'session' => $sessionId
        ]);
    }
}
