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

namespace Vaimo\IntentPredictor\Model;

use Magento\Framework\Model\AbstractModel;

class IntentSession extends AbstractModel
{
    public const INTENT_LEVEL_HIGH = 'high';
    public const INTENT_LEVEL_MEDIUM = 'medium';
    public const INTENT_LEVEL_LOW = 'low';

    protected function _construct()
    {
        $this->_init(ResourceModel\IntentSession::class);
    }
}
