<?php

return [
    'columns' => [
        'text' => [
            'actions' => [
                'collapse_list' => 'Show :count less',
                'expand_list' => 'Show :count more',
            ],
        ],
    ],
    'fields' => [
        'bulk_select_page' => 'Select all',
        'bulk_select_record' => 'Select :name',
        'search' => 'Search',
    ],
    'filters' => [
        'indicator' => 'Active filters',
        'fields' => [
            'created_from' => 'Created from',
            'created_until' => 'Created until',
            'select' => [
                'placeholder' => 'All',
            ],
            'trashed' => [
                'label' => 'Deleted records',
                'only_trashed' => 'Only deleted records',
                'with_trashed' => 'With deleted records',
                'without_trashed' => 'Without deleted records',
            ],
        ],
        'actions' => [
            'remove' => 'Remove filter',
            'remove_all' => 'Remove all filters',
            'reset' => 'Reset',
        ],
    ],
    'grouping' => [
        'fields' => [
            'group' => [
                'label' => 'Group by',
                'placeholder' => 'Group by',
            ],
            'direction' => [
                'label' => 'Group direction',
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ],
            ],
        ],
    ],
    'reorder_indicator' => 'Drag and drop the records into order.',
    'selection_indicator' => [
        'selected_count' => '1 record selected.|:count records selected.',
        'actions' => [
            'select_all' => [
                'label' => 'Select all :count',
            ],
            'deselect_all' => [
                'label' => 'Deselect all',
            ],
        ],
    ],
    'sorting' => [
        'fields' => [
            'column' => [
                'label' => 'Sort by',
            ],
            'direction' => [
                'label' => 'Sort direction',
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ],
            ],
        ],
    ],
];

