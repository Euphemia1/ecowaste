<?php
/**
 * Payment Configuration
 * Flutterwave payment gateway settings for mobile money integration
 */

return [
    'flutterwave' => [
        'public_key' => getenv('FLW_PUBLIC_KEY') ?: '',
        'secret_key' => getenv('FLW_SECRET_KEY') ?: '',
        'encryption_key' => getenv('FLW_ENCRYPTION_KEY') ?: '',
        'environment' => getenv('FLW_ENVIRONMENT') ?: 'sandbox', // sandbox or live
        'webhook_secret_hash' => getenv('FLW_WEBHOOK_SECRET') ?: '',
    ],

    'payment_methods' => [
        'mobile_money' => [
            'mtn' => [
                'enabled' => true,
                'display_name' => 'MTN Mobile Money',
                'code' => 'MTN',
            ],
            'airtel' => [
                'enabled' => true,
                'display_name' => 'Airtel Money',
                'code' => 'AIRTEL',
            ],
        ],
        'cash' => [
            'enabled' => true,
            'display_name' => 'Cash on Pickup',
        ],
    ],

    'currency' => 'ZMW',
    'country' => 'ZM',

    'webhook_url' => getenv('APP_URL') . '/api/payment/webhook',
    
    // Fee configuration
    'fees' => [
        'transaction_fee_percent' => 1.4, // 1.4% Flutterwave fee  
        'vat_percent' => 16, // Zambia VAT
    ],

    // Payment flow settings
    'redirect_url' => getenv('APP_URL') . '/payment/callback',
    'cancel_url' => getenv('APP_URL') . '/payment/cancelled',
];
