
<?php
return [
    'SYSTEM_NAME' => 'Project Management',

    'CHARGE_TYPE' => [
        '1' => 'Addition (+)',
        '2' => 'Subtraction (-)',
        '3' => 'Percentage (%) Addition',
        '4' => 'Percentage (%) Subtraction',
        // '5' => 'Division (/) Addition',
        // '6' => 'Division (/) Subtraction',
        // '7' => 'Modulus (%) Addition',
        // '8' => 'Modulus (%) Subtraction',
    ],

    // 'HISTORY_ORDER_STATUS' => [
    //     '1' => [
    //         'title' => "Pending",
    //         'color' => '#FFA500', // Orange
    //         'background-color' => 'rgba(255, 165, 0, 0.1)', // Light Orange
    //         'description' => 'Your order has been placed successfully and is awaiting confirmation.',
    //     ],
    //     '2' => [
    //         'title' => "Accepted",
    //         'color' => '#0056b3', // Darker Blue
    //         'background-color' => 'rgba(0, 86, 179, 0.1)', // Very Light Blue
    //         'description' => 'Your order has been accepted! It will be processed and dispatched soon.',
    //     ],
    //     '3' => [
    //         'title' => "Rejected",
    //         'color' => '#c82333', // Dark Red
    //         'background-color' => 'rgba(220, 53, 69, 0.1)', // Light Red
    //         'description' => 'Your order has been cancelled.',
    //     ],
    //     '4' => [
    //         'title' => "Shipped",
    //         'color' => '#7239ea', // Purple
    //         'background-color' => '#f8f5ff', // Very Light Purple
    //         'description' => 'Your order has been shipped! A tracking number will be provided soon.',
    //     ],
    //     '5' => [
    //         'title' => "Delivered",
    //         'color' => '#28a745', // Green
    //         'background-color' => '#eaffea', // Very Light Green
    //         'description' => 'Your order has been delivered successfully!',
    //     ],
    //     '6' => [
    //         'title' => "Payment Pending",
    //         'color' => '#FFA500', // Deep Orange
    //         'background-color' => 'rgba(255, 165, 0, 0.1)', // Very Light Deep Orange
    //         'description' => 'Payment has not yet been completed. Please finalize your payment to proceed.',
    //     ],
    //     '7' => [
    //         'title' => "Payment Received",
    //         'color' => '#17c653', // Dark Green
    //         'background-color' => '#dfffea', // Light Green
    //         'description' => 'Your payment has been successfully received! Thank you.',
    //     ],
    //     '8' => [
    //         'title' => "Payment Not Received",
    //         'color' => '#f8285a', // Dark Red
    //         'background-color' => '#ffeef3', // Light Red
    //         'description' => 'Payment was unsuccessful. Please check your payment method and try again.',
    //     ],
    // ],

    'PAYMENT_MODE' => [
        // '1' => "Cash", 
        '2' => "Cheque",
        '3' => "Gpay",
        '4' => "Phone Pe",
        '5' => "Paytm",
        '6' => "Others"
    ],
    
    'HISTORY_ORDER_STATUS' => [
        '1' => [
            'title' => "Pending",
            'color' => '#FFA500',
            'background-color' => 'rgba(255, 165, 0, 0.1)',
            'description' => 'Your order is placed, please wait for the admin accepted.',
        ],
        '2' => [
            'title' => "Accepted",
            'color' => '#0056b3',
            'background-color' => 'rgba(0, 86, 179, 0.1)',
            'description' => 'Your order has been accepted.',
        ],
        '3' => [
            'title' => "Rejected",
            'color' => '#c82333',
            'background-color' => 'rgba(220, 53, 69, 0.1)',
            'description' => 'Your order was cancelled.',
        ],
        '4' => [
            'title' => "Shipped",
            'color' => '#7239ea',
            'background-color' => '#f8f5ff',
            'description' => 'Your order is on the way.',
        ],
        '5' => [
            'title' => "Delivered",
            'color' => '#28a745',
            'background-color' => '#eaffea',
            'description' => 'Your order has been delivered.',
        ],
        '6' => [
            'title' => "Payment Pending",
            'color' => '#FFA500',
            'background-color' => 'rgba(255, 165, 0, 0.1)',
            'description' => 'Waiting for payment to be completed.',
        ],
        '7' => [
            'title' => "Payment Received",
            'color' => '#17c653',
            'background-color' => '#dfffea',
            'description' => 'Payment was received!',
        ],
        '8' => [
            'title' => "Payment Not Received",
            'color' => '#f8285a',
            'background-color' => '#ffeef3',
            'description' => 'Payment has been not received.',
        ], 
    ],

]
   


?>
