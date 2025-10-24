<?php
/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
 */
declare(strict_types=1);

namespace Vaimo\IntentPredictor\Model;

use Magento\Framework\Event\ManagerInterface;
use Vaimo\IntentPredictor\Model\IntentSessionFactory;
use Vaimo\IntentPredictor\Model\ResourceModel\IntentSession\CollectionFactory;

class Scoring
{
    public function __construct(
        private readonly ManagerInterface $eventManager,
        private readonly IntentSessionFactory $intentSessionFactory,
        private readonly CollectionFactory $intentSessionCollectionFactory,
    ) {
    }

    public function createSessionRecord(array $data, string $sessionId, string $customerId, float $score): void
    {
        $collection = $this->intentSessionCollectionFactory->create()
            ->addFieldToFilter('session_id', $sessionId)
            ->setPageSize(1);

        $intent = $collection->getFirstItem();

        // If no existing record, create a new one
        if (!$intent->getId()) {
            /** @var IntentSession $intent */
            $intent = $this->intentSessionFactory->create();
            $intent->addData([
                'session_id' => $sessionId,
                'customer_id' => $customerId ?? null,
            ]);
        }

        $intent->addData([
            'pages_viewed'  => $data['pages_viewed'] ?? $intent->getPagesViewed(),
            'time_spent'    => $data['time_spent'] ?? $intent->getTimeSpent(),
            'added_to_cart' => !empty($data['added_to_cart']) ? 1 : $intent->getAddedToCart(),
            'intent_score'  => $score,
        ]);

        $intent->save();
    }

    public function calculateScore(array $data, string $sessionId, string $customerId): array
    {
        $score = 0;
        $score += ($data['pages_viewed'] ?? 0) * 5;
        $score += ($data['time_spent'] ?? 0) * 0.1;
        if (!empty($data['added_to_cart'])) $score += 50;

        $intent = IntentSession::INTENT_LEVEL_LOW;
        if ($score > 100) $intent = IntentSession::INTENT_LEVEL_HIGH;
        elseif ($score > 40) $intent = IntentSession::INTENT_LEVEL_MEDIUM;

        // 🔥 Dispatch event
        $this->eventManager->dispatch(
            'vaimo_intentpredictor_score_updated',
            [
                'intent_score' => $intent,
                'session_id' => $sessionId
            ],
        );

        $this->createSessionRecord($data, $sessionId, $customerId, (float) $score);

        return ['intent' => $intent, 'score' => $score];
    }
}
