<?php

if (!defined('ABSPATH')) {
    exit();
}

add_filter(
    'forms_bridge_load_workflow_jobs',
    function ($jobs, $api) {
        if ($api !== 'rest-api') {
            return $jobs;
        }

        if (!wp_is_numeric_array($jobs)) {
            $jobs = [];
        }

        $jobs[] = [
            'name' => 'ce-crm-metadata',
            'data' => [
                'title' => __('CRM metadata', 'wpct-ce'),
                'description' => __(
                    'Converteix un mapa de clau valor a una col·lecció de daes compatibles amb el mòdul metadata del CRM d\'Odoo',
                    'wpct-ce',
                ),
                'method' => 'wpct_ce_crm_metadata',
                'input' => [
                    [
                        'name' => 'metadata',
                        'required' => true,
                        'schema' => [
                            'type' => 'object',
                            'properties' => [],
                            'additionalProperties' => true,
                        ],
                    ]
                ],
                'output' => [
                    [
                        'name' => 'metadata',
                        'schema' => [
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'key' => ['type' => 'string'],
                                    'value' => ['type' => 'string'],
                                ],
                                'additionalItems' => true,
                            ],
                        ],
                        'touch' => true,
                    ],
                ],
            ],
            $api,
        ];

        return $jobs;
    },
    10,
    2
);
