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

namespace SinhaR\IntentPredictor\Observer;

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
