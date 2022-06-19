<?php
return [
    'service_manager' => [
        'factories' => [
            \Billing\V1\Rest\Billing\BillingResource::class => \Billing\V1\Rest\Billing\BillingResourceFactory::class,
            \Billing\V1\Rest\Billing\BillingMapper::class => \Billing\V1\Rest\Billing\BillingMapperFactory::class,
            \Billing\V1\Rest\User\UserResource::class => \Billing\V1\Rest\User\UserResourceFactory::class,
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
            'billing.rest.user' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/user[/:user_id]',
                    'defaults' => [
                        'controller' => 'Billing\\V1\\Rest\\User\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'billing.rest.billing',
            1 => 'billing.rest.user',
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
        'Billing\\V1\\Rest\\User\\Controller' => [
            'listener' => \Billing\V1\Rest\User\UserResource::class,
            'route_name' => 'billing.rest.user',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'user',
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
            'entity_class' => \Billing\V1\Rest\User\UserEntity::class,
            'collection_class' => \Billing\V1\Rest\User\UserCollection::class,
            'service_name' => 'User',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'Billing\\V1\\Rest\\Billing\\Controller' => 'HalJson',
            'Billing\\V1\\Rest\\User\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Billing\\V1\\Rest\\Billing\\Controller' => [
                0 => 'application/vnd.billing.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Billing\\V1\\Rest\\User\\Controller' => [
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
            'Billing\\V1\\Rest\\User\\Controller' => [
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
            \Billing\V1\Rest\User\UserEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'billing.rest.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \Billing\V1\Rest\User\UserCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'billing.rest.user',
                'route_identifier_name' => 'user_id',
                'is_collection' => true,
            ],
        ],
    ],
];
