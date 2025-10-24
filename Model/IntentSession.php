<?php
/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
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
