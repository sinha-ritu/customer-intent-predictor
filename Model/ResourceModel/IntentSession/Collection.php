<?php
/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
 */
declare(strict_types=1);

namespace Vaimo\IntentPredictor\Model\ResourceModel\IntentSession;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vaimo\IntentPredictor\Model\IntentSession as Model;
use Vaimo\IntentPredictor\Model\ResourceModel\IntentSession as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
