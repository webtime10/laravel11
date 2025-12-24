<?php

return [
    'columns' => [
        'text' => [
            'actions' => [
                'collapse_list' => 'Показать на :count меньше',
                'expand_list' => 'Показать еще :count',
            ],
        ],
    ],
    'fields' => [
        'bulk_select_page' => 'Выбрать все',
        'bulk_select_record' => 'Выбрать :name',
        'search' => 'Поиск',
    ],
    'filters' => [
        'indicator' => 'Активные фильтры',
        'fields' => [
            'created_from' => 'Создано с',
            'created_until' => 'Создано до',
            'select' => [
                'placeholder' => 'Все',
            ],
            'trashed' => [
                'label' => 'Удаленные записи',
                'only_trashed' => 'Только удаленные записи',
                'with_trashed' => 'С удаленными записями',
                'without_trashed' => 'Без удаленных записей',
            ],
        ],
        'actions' => [
            'remove' => 'Удалить фильтр',
            'remove_all' => 'Удалить все фильтры',
            'reset' => 'Сбросить',
        ],
    ],
    'grouping' => [
        'fields' => [
            'group' => [
                'label' => 'Группировать по',
                'placeholder' => 'Группировать по',
            ],
            'direction' => [
                'label' => 'Направление группировки',
                'options' => [
                    'asc' => 'По возрастанию',
                    'desc' => 'По убыванию',
                ],
            ],
        ],
    ],
    'reorder_indicator' => 'Перетащите записи для изменения порядка.',
    'selection_indicator' => [
        'selected_count' => 'Выбрана 1 запись.|Выбрано :count записей.',
        'actions' => [
            'select_all' => [
                'label' => 'Выбрать все :count',
            ],
            'deselect_all' => [
                'label' => 'Снять выделение',
            ],
        ],
    ],
    'sorting' => [
        'fields' => [
            'column' => [
                'label' => 'Сортировать по',
            ],
            'direction' => [
                'label' => 'Направление сортировки',
                'options' => [
                    'asc' => 'По возрастанию',
                    'desc' => 'По убыванию',
                ],
            ],
        ],
    ],
];

