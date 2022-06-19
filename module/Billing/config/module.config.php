<?php
return [
    'service_manager' => [
        'factories' => [
            \Billing\V1\Rest\Billing\BillingResource::class => \Billing\V1\Rest\Billing\BillingResourceFactory::class,
            \Billing\V1\Rest\Billing\BillingMapper::class => \Billing\V1\Rest\Billing\BillingMapperFactory::class,
            \Billing\V1\Rest\Company\CompanyResource::class => \Billing\V1\Rest\Company\CompanyResourceFactory::class,
            \Billing\V1\Rest\Company\CompanyMapper::class => \Billing\V1\Rest\Company\CompanyMapperFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'billing.rest.billing' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/billing[/:billing_id]',
                    'defaults' => [
                        'controller' => 'Billing\\V1\\Rest\\Billing\\Controller',
                    ],
                ],
            ],
            'billing.rest.company' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/company[/:company_id]',
                    'defaults' => [
                        'controller' => 'Billing\\V1\\Rest\\Company\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'billing.rest.billing',
            2 => 'billing.rest.company',
        ],
    ],
    'api-tools-rest' => [
        'Billing\\V1\\Rest\\Billing\\Controller' => [
            'listener' => \Billing\V1\Rest\Billing\BillingResource::class,
            'route_name' => 'billing.rest.billing',
            'route_identifier_name' => 'billing_id',
            'collection_name' => 'billing',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Billing\V1\Rest\Billing\BillingEntity::class,
            'collection_class' => \Billing\V1\Rest\Billing\BillingCollection::class,
            'service_name' => 'Billing',
        ],
        'Billing\\V1\\Rest\\Company\\Controller' => [
            'listener' => \Billing\V1\Rest\Company\CompanyResource::class,
            'route_name' => 'billing.rest.company',
            'route_identifier_name' => 'company_id',
            'collection_name' => 'company',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Billing\V1\Rest\Company\CompanyEntity::class,
            'collection_class' => \Billing\V1\Rest\Company\CompanyCollection::class,
            'service_name' => 'Company',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'Billing\\V1\\Rest\\Billing\\Controller' => 'HalJson',
            'Billing\\V1\\Rest\\Company\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Billing\\V1\\Rest\\Billing\\Controller' => [
                0 => 'application/vnd.billing.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Billing\\V1\\Rest\\Company\\Controller' => [
                0 => 'application/vnd.billing.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Billing\\V1\\Rest\\Billing\\Controller' => [
                0 => 'application/vnd.billing.v1+json',
                1 => 'application/json',
            ],
            'Billing\\V1\\Rest\\Company\\Controller' => [
                0 => 'application/vnd.billing.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \Billing\V1\Rest\Billing\BillingEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'billing.rest.billing',
                'route_identifier_name' => 'billing_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \Billing\V1\Rest\Billing\BillingCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'billing.rest.billing',
                'route_identifier_name' => 'billing_id',
                'is_collection' => true,
            ],
            \Billing\V1\Rest\Company\CompanyEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'billing.rest.company',
                'route_identifier_name' => 'company_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \Billing\V1\Rest\Company\CompanyCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'billing.rest.company',
                'route_identifier_name' => 'company_id',
                'is_collection' => true,
            ],
        ],
    ],
];
