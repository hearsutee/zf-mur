<?php
return array(
    'router' => array(
        'routes' => array(
            'mur-api.rest.mur-rest' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/mur-rest[/:mur_rest_id]',
                    'defaults' => array(
                        'controller' => 'MurApi\\V1\\Rest\\MurRest\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'mur-api.rest.mur-rest',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'MurApi\\V1\\Rest\\MurRest\\MurRestResource' => 'MurApi\\V1\\Rest\\MurRest\\MurRestResourceFactory',
        ),
    ),
    'zf-rest' => array(
        'MurApi\\V1\\Rest\\MurRest\\Controller' => array(
            'listener' => 'MurApi\\V1\\Rest\\MurRest\\MurRestResource',
            'route_name' => 'mur-api.rest.mur-rest',
            'route_identifier_name' => 'mur_rest_id',
            'collection_name' => 'mur_rest',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'MurApi\\V1\\Rest\\MurRest\\MurRestEntity',
            'collection_class' => 'MurApi\\V1\\Rest\\MurRest\\MurRestCollection',
            'service_name' => 'MurRest',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'MurApi\\V1\\Rest\\MurRest\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'MurApi\\V1\\Rest\\MurRest\\Controller' => array(
                0 => 'application/vnd.mur-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'MurApi\\V1\\Rest\\MurRest\\Controller' => array(
                0 => 'application/vnd.mur-api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'MurApi\\V1\\Rest\\MurRest\\MurRestEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'mur-api.rest.mur-rest',
                'route_identifier_name' => 'mur_rest_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'MurApi\\V1\\Rest\\MurRest\\MurRestCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'mur-api.rest.mur-rest',
                'route_identifier_name' => 'mur_rest_id',
                'is_collection' => true,
            ),
        ),
    ),
);
