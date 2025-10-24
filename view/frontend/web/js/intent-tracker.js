<!--
  Copyright © 2025 Ritu Sinha

  This source code is licensed under the MIT license
  that is bundled with this package in the file LICENSE.

  You are free to use, modify, and distribute this software
  in accordance with the terms of the MIT License.
-->
define(['jquery', 'mage/url'], function ($, urlBuilder) {
    'use strict';

    // --- State Tracking ---
    let startTime = Date.now();
    let pageViews = parseInt(sessionStorage.getItem('vaimo_intent_pageviews') || '0', 10);
    let addedToCart = false;

    // Increment page view count
    pageViews++;
    sessionStorage.setItem('vaimo_intent_pageviews', pageViews);

    // --- Helper: Compute time spent ---
    function getTimeSpentSeconds() {
        const now = Date.now();
        return Math.round((now - startTime) / 1000);
    }

    // --- Helper: Send Data to Backend ---
    function sendIntentData(trigger) {
        const payload = {
            pages_viewed: pageViews,
            time_spent: getTimeSpentSeconds(),
            added_to_cart: addedToCart,
            trigger: trigger || 'auto'
        };

        $.ajax({
            url: urlBuilder.build('intent/intent/score'),
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(payload),
            success: function (res) {
                if (res.intent) {
                    document.dispatchEvent(new CustomEvent('intentScoreUpdated', { detail: res.score }));
                    console.debug('[IntentPredictor] Intent score updated:', res.intent);
                }
            },
            error: function () {
                console.warn('[IntentPredictor] Error sending intent data.');
            }
        });
    }

    // --- Event: Add to Cart Detection ---
    $(document).on('ajax:addToCart', function () {
        addedToCart = true;
        sendIntentData('addToCart');
    });

    // --- Event: Page Unload (send data before leaving) ---
    $(window).on('beforeunload', function () {
        sendIntentData('unload');
    });

    // --- Optional: Periodic Auto-Tracking ---
    setInterval(function () {
        sendIntentData('interval');
    }, 5 * 60 * 1000); // every 60s

    // Expose public API (for debugging or future integration)
    window.VaimoIntentTracker = {
        send: sendIntentData,
        getStats: function () {
            return {
                pages_viewed: pageViews,
                time_spent: getTimeSpentSeconds(),
                added_to_cart: addedToCart
            };
        }
    };

    console.debug('[IntentPredictor] Tracking started. Page views:', pageViews);
});
