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

namespace SinhaR\IntentPredictor\Model\ResourceModel\IntentSession;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SinhaR\IntentPredictor\Model\IntentSession as Model;
use SinhaR\IntentPredictor\Model\ResourceModel\IntentSession as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
