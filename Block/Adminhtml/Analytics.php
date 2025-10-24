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

namespace SinhaR\IntentPredictor\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Framework\Serialize\Serializer\Json;
use SinhaR\IntentPredictor\Model\IntentSession;
use SinhaR\IntentPredictor\Model\ResourceModel\IntentSession\CollectionFactory;

class Analytics extends Template
{
    public function __construct(
        Template\Context $context,
        private readonly CollectionFactory $collectionFactory,
        private readonly Json $jsonHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getIntentData(): false|string
    {
        $collection = $this->collectionFactory->create();
        $data = [];
        foreach ($collection as $item) {
            $data[] = [
                'session_id' => $item->getSessionId(),
                'score' => $item->getIntentScore(),
                'intent_type' => $this->determineIntentType($item),
                'updated_at' => $item->getUpdatedAt(),
            ];
        }

        return $this->jsonHelper->serialize($data);
    }

    public function determineIntentType(IntentSession $item): string
    {
        $addedToCart = (int)$item->getAddedToCart();
        $pagesViewed = (int)$item->getPagesViewed();
        $timeSpent = (int)$item->getTimeSpent();
        $score = (int)$item->getIntentScore();

        if ($addedToCart > 0 && $score < 50) {
            return 'Abandonment Risk';
        }

        if ($addedToCart > 0) {
            return 'Purchase';
        }

        if ($pagesViewed >= 5 && $timeSpent >= 180 && $score >= 70) {
            return 'High Intent';
        }

        if ($pagesViewed >= 3 && $timeSpent >= 60 && $addedToCart == 0) {
            return 'Research';
        }

        if ($pagesViewed < 3 && $timeSpent < 60) {
            return 'Browse';
        }

        return 'Unknown';
    }
}
