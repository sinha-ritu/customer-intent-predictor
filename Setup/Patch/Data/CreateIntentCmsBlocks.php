<?php
/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
 */
declare(strict_types=1);

namespace Vaimo\IntentPredictor\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\App\State;

class CreateIntentCmsBlocks implements DataPatchInterface
{
    protected $blockFactory;
    protected $appState;

    public function __construct(BlockFactory $blockFactory, State $appState)
    {
        $this->blockFactory = $blockFactory;
        $this->appState = $appState;
    }

    public function apply()
    {
        try {
            $this->appState->setAreaCode('frontend');
        } catch (\Exception $e) {}

        $blocks = [
            [
                'identifier' => 'intent_low_trust_block',
                'title' => 'Low Intent - Educational Block',
                'content' => '<div class="intent-block low-intent">
                                <h3>Welcome!</h3>
                                <p>Explore our guides and learn more about what makes our products unique.</p>
                                <a href="/blog">Visit our Blog</a>
                              </div>',
            ],
            [
                'identifier' => 'intent_medium_socialproof_block',
                'title' => 'Medium Intent - Social Proof Block',
                'content' => '<div class="intent-block medium-intent">
                                <h3>Trusted by Thousands</h3>
                                <p>Over 10,000 customers love our quality and service.</p>
                                <a href="/testimonials">Read Reviews</a>
                              </div>',
            ],
            [
                'identifier' => 'intent_high_offer_block',
                'title' => 'High Intent - Offer Block',
                'content' => '<div class="intent-block high-intent">
                                <h3>Special Offer Just for You</h3>
                                <p>Complete your purchase today and enjoy 10% off your order!</p>
                                <a href="/checkout" class="action primary">Go to Checkout</a>
                              </div>',
            ],
        ];

        foreach ($blocks as $data) {
            $exists = $this->blockFactory->create()->load($data['identifier'], 'identifier');
            if (!$exists->getId()) {
                $this->blockFactory->create()
                    ->setTitle($data['title'])
                    ->setIdentifier($data['identifier'])
                    ->setContent($data['content'])
                    ->setIsActive(1)
                    ->setStores([0])
                    ->save();
            }
        }

        return $this;
    }

    public static function getDependencies() { return []; }
    public function getAliases() { return []; }
}
