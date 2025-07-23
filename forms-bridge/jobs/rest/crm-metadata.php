<?php

return [
    'title' => __('CRM Metadata', 'wpct-ce'),
    'description' => __(
        'Converteix un mapa de clau valor a una col·lecció de dades compatibles amb el mòdul metadata del CRM d\'Odoo',
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
];

function wpct_ce_crm_metadata($payload)
{
    $metadata = [];
    foreach ($payload['metadata'] as $key => $value) {
        $metadata[] = ['key' => $key, 'value' => $value];
    }

    $payload['metadata'] = $metadata;
    return $metadata;
}
