<?php

if (!defined('WPCT_CE_LANDING_POST_TYPE')) {
    define('WPCT_CE_LANDING_POST_TYPE', 'rest-ce-landing');
}

if (!defined('WPCT_CE_COORD_POST_TYPE')) {
    define('WPCT_CE_COORD_POST_TYPE', 'rest-ce-coord');
}

if (!defined('WPCT_CE_REST_TYPE_TAX')) {
    define('WPCT_CE_REST_TYPE_TAX', 'rest-ce-type');
}

if (!defined('WPCT_CE_REST_TYPE_TERMS')) {
    define('WPCT_CE_REST_TYPE_TERMS', [
        [
            'name' => __('Ciutadania', 'wpct-ce'),
            'slug' => 'citizen'
        ],
        [
            'name' => __('Empresa i indústria', 'wpct-ce'),
            'slug' => 'industrial',
        ],
    ]);
}

if (!defined('WPCT_CE_REST_STATUS_TAX')) {
    define('WPCT_CE_REST_STATUS_TAX', 'rest-ce-status');
}

if (!defined('WPCT_CE_REST_STATUS_TERMS')) {
    define('WPCT_CE_REST_STATUS_TERMS', [
        [
            'name' => __('Oberta', 'wpct-ce'),
            'slug' => 'open'
        ],
        [
            'name' => __('Tancada', 'wpct-ce'),
            'slug' => 'closed',
        ],
    ]);
}

if (!defined('WPCT_CE_REST_SERVICE_TAX')) {
    define('WPCT_CE_REST_SERVICE_TAX', 'rest-ce-service');
}

if (!defined('WPCT_CE_REST_SERVICE_TERMS')) {
    define('WPCT_CE_REST_SERVICE_TERMS', [
        [
            'name' => __('Generació renovable comunitàtia', 'wpct-ce'),
            'slug' => 'generacio-renovable'
        ],
        [
            'name' => __('Mobilitat sostenible', 'wpct-ce'),
            'slug' => 'mobilitat-sostenible',
        ],
        [
            'name' => __('Eficiència energètica', 'wpct-ce'),
            'slug' => 'eficiencia-energetica',
        ],
        [
            'name' => __('Formació ciutadana', 'wpct-ce'),
            'slug' => 'formacio-ciutadana',
        ],
        [
            'name' => __('Energia tèrmica i climatització', 'wpct-ce'),
            'slug' => 'energia-termica',
        ],
        [
            'name' => __('Subministrament d\'energia renovable', 'wpct-ce'),
            'slug' => 'subministrament-renovable',
        ],
        [
            'name' => __('Compres col·lectives', 'wpct-ce'),
            'slug' => 'compres-colectives',
        ],
        [
            'name' => __('Agregació i flexibilitat de la demanda', 'wpct-ce'),
            'slug' => 'agregacio-demanda'
        ]
    ]);
}

if (!defined('WPCT_CE_REST_SERVICE_XML_SOURCES')) {
    define('WPCT_CE_REST_SERVICE_XML_SOURCES', [
        'generacio-renovable' => 'ce_tag_common_generation',
        'eficiencia-energetica' => 'ce_tag_energy_efficiency',
        'mobilitat-sostenible' => 'ce_tag_sustainable_mobility',
        'formacio-ciutadana' => 'ce_tag_citizen_education',
        'energia-termica' => 'ce_tag_thermal_energy',
        'compres-colectives' => 'ce_tag_collective_purchases',
        'subministrament-renovable' => 'ce_tag_renewable_energy',
        'agregacio-demanda' => 'ce_tag_aggregate_demand'
    ]);
}

if (!defined('WPCT_CE_REST_ASSOC_TYPE_TAX')) {
    define('WPCT_CE_REST_ASSOC_TYPE_TAX', 'rest-ce-assoc-type');
}

if (!defined('WPCT_CE_REST_ASSOC_TYPE_TERMS')) {
    define('WPCT_CE_REST_ASSOC_TYPE_TERMS', [
        [
            'name' => __('Cooperativa', 'wpct-ce'),
            'slug' => 'cooperative'
        ],
        [
            'name' => __('Associació sense ànim de lucre', 'wpct-ce'),
            'slug' => 'non_profit'
        ],
        [
            'name' => __('En definició', 'wpct-ce'),
            'slug' => 'undefined'
        ],
        [
            'name' => __('Societat Limitada', 'wpct-ce'),
            'slug' => 'limited_company'
        ],
        [
            'name' => __('Societat Col·lectiva', 'wpct-ce'),
            'slug' => 'general_partnership'
        ],
        [
            'name' => __('Comunitat de Bens', 'wpct-ce'),
            'slug' => 'community_of_property'
        ],
        [
            'name' => __('Societat Comanditària', 'wpct-ce'),
            'slug' => 'limited_partnership'
        ],
        [
            'name' => __('Societat Anónima', 'wpct-ce'),
            'slug' => 'stock_company'
        ],
        [
            'name' => __('Empresari Individual', 'wpct-ce'),
            'slug' => 'individual_entrepreneur'
        ]
    ]);
}
