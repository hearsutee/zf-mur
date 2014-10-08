<?php
return array(
    'router' => array(
        'routes' => array(),
    ),
    'zf-versioning' => array(
        'uri' => array(),
    ),
    'service_manager' => array(
        'factories' => array(),
    ),
    'zf-rest' => array(),
    'zf-content-negotiation' => array(
        'controllers' => array(),
        'accept_whitelist' => array(),
        'content_type_whitelist' => array(),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'TestApi\\V1\\Rest\\User\\UserEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'test-api.rest.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
        ),
    ),
);
