# Magento 2 Customer Intent Predictor Module

## Overview

This Magento 2 module analyzes customer browsing behavior to calculate an 'intent score,' predicting their likelihood to make a purchase. It provides valuable insights to store administrators through a visual dashboard, helping to understand the correlation between browsing patterns and conversion rates.

## Features

*   Real-time tracking of customer browsing activity.
*   A scoring system to quantify customer purchase intent.
*   An admin grid and chart to visualize browsing behavior vs. conversion data.
*   Dynamic frontend blocks that can be displayed based on customer intent levels.

## Installation

1.  Install the module via Composer:
    ```bash
    composer require sinhar/module-intent-predictor
    ```

2.  Enable the module and run the setup scripts:
    ```bash
    bin/magento module:enable SinhaR_IntentPredictor
    bin/magento setup:upgrade
    bin/magento setup:di:compile
    bin/magento setup:static-content:deploy
    ```

## Configuration

1.  Navigate to **Stores > Configuration > Sales > Intent Predictor**.
2.  **Enable**: Set to "Yes" to activate the module's tracking functionality.
3.  **High Intent Threshold**: Define the score at which a customer is considered to have 'high intent'. The default is 100.

## Usage

### Frontend Tracking

Once the module is enabled, it automatically begins tracking customer browsing behavior on the frontend of your store. No manual setup is required for the tracking to start.

### Admin Analytics

To view the customer intent analytics dashboard:

1.  Log in to the Magento Admin panel.
2.  Navigate to **Content > Intent Predictor > Session Analytics**.
3.  This dashboard presents a chart visualizing the ratio of browsing behavior to conversions, allowing you to analyze the effectiveness of your store's user journey.
