<?php

return [
    'components' => [
        'pagination' => [
            'fields' => [
                'records_per_page' => [
                    'label' => 'Записей на странице',
                    'options' => [
                        'all' => 'Все',
                    ],
                ],
            ],
            'overview' => [
                'label' => 'Показано с :first по :last из :total записей',
            ],
        ],
        'modal' => [
            'actions' => [
                'close' => 'Закрыть',
                'confirm' => 'Подтвердить',
                'cancel' => 'Отмена',
            ],
        ],
    ],
    'layout' => [
        'actions' => [
            'dark_mode_toggle' => [
                'label' => 'Переключить темный режим',
            ],
            'database_notifications' => [
                'label' => 'Открыть уведомления',
            ],
            'open_database_notifications' => [
                'label' => 'Открыть уведомления',
            ],
            'sidebar' => [
                'collapse' => 'Свернуть боковую панель',
                'expand' => 'Развернуть боковую панель',
            ],
        ],
    ],
    'pages' => [
        'auth' => [
            'login' => [
                'form' => [
                    'heading' => 'Вход',
                    'actions' => [
                        'authenticate' => [
                            'label' => 'Войти',
                        ],
                    ],
                ],
                'notifications' => [
                    'throttled' => [
                        'title' => 'Слишком много попыток входа',
                        'body' => 'Пожалуйста, попробуйте снова через :seconds секунд.',
                    ],
                ],
            ],
        ],
    ],
];

