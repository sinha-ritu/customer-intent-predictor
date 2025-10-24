<!--
  Copyright © 2025 Ritu Sinha

  This source code is licensed under the MIT license
  that is bundled with this package in the file LICENSE.

  You are free to use, modify, and distribute this software
  in accordance with the terms of the MIT License.
-->
define(['jquery', 'mage/url'], function ($, urlBuilder) {
    'use strict';

    function loadBlockByIntent(score) {
        let identifier = '';

        if (score < 50) identifier = 'intent_low_trust_block';
        else if (score < 1000) identifier = 'intent_medium_socialproof_block';
        else identifier = 'intent_high_offer_block';

        // Call the REST API to get CMS block HTML
        const endpoint = urlBuilder.build('rest/V1/cmsBlock/' + identifier);

        $.ajax({
            url: endpoint,
            method: 'GET',
            success: function (res) {
                if (res && res.content) {
                    $('#intent-block-container').html(res.content);
                } else {
                    $('#intent-block-container').html('<p>No personalized content available.</p>');
                }
            },
            error: function () {
                $('#intent-block-container').html('<p>Unable to load content right now.</p>');
            }
        });
    }

    // Listen for intent score updates (from your existing tracker)
    document.addEventListener('intentScoreUpdated', function (e) {
        const score = e.detail;
        console.log('[IntentPredictor] Received score update in load-intent-block.js:', score);
        loadBlockByIntent(score);
    });

    // Optional: Load a default block when page loads (e.g., 0 intent)
    $(document).ready(function () {
        loadBlockByIntent(0);
    });

    return {
        loadBlockByIntent: loadBlockByIntent
    };
});
