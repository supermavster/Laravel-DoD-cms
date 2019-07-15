<?php
return [
    'client_id' => env('PAYPAL_CLIENT_ID'),
    'secret' => env('PAYPAL_CLIENT_SECRET'),

    /**
     * SDK configuration
     */
    'settings' => [

        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ],
    'webhooks' => [
        'payment_sale_completed' => env('PAYPAL_PAYMENT_SALE_COMPLETED_WEBHOOK_ID'),
    ],
];
