<?php
/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
 */
declare(strict_types=1);

namespace Vaimo\IntentPredictor\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class IntentScoreObserver implements ObserverInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $score = $observer->getData('intent_score');
        $sessionId = $observer->getData('session_id');

        // Example: log or perform business logic
        $this->logger->info('Intent Score Updated', [
            'session_id' => $sessionId,
            'score' => $score
        ]);

        // Example placeholder: if high intent, you could trigger a promotion logic here.
        if ($score === 'high') {
            // TODO: integrate with marketing logic, cart discount, etc.
        }
    }
}
