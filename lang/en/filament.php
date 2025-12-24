<?php

return [
    'components' => [
        'pagination' => [
            'fields' => [
                'records_per_page' => [
                    'label' => 'Records per page',
                    'options' => [
                        'all' => 'All',
                    ],
                ],
            ],
        ],
        'modal' => [
            'actions' => [
                'close' => 'Close',
                'confirm' => 'Confirm',
                'cancel' => 'Cancel',
            ],
        ],
    ],
    'layout' => [
        'actions' => [
            'dark_mode_toggle' => [
                'label' => 'Toggle dark mode',
            ],
            'database_notifications' => [
                'label' => 'Open notifications',
            ],
            'open_database_notifications' => [
                'label' => 'Open notifications',
            ],
            'sidebar' => [
                'collapse' => 'Collapse sidebar',
                'expand' => 'Expand sidebar',
            ],
        ],
    ],
    'pages' => [
        'auth' => [
            'login' => [
                'form' => [
                    'heading' => 'Login',
                    'actions' => [
                        'authenticate' => [
                            'label' => 'Sign in',
                        ],
                    ],
                ],
                'notifications' => [
                    'throttled' => [
                        'title' => 'Too many login attempts',
                        'body' => 'Please try again in :seconds seconds.',
                    ],
                ],
            ],
        ],
    ],
];

