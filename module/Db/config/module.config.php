<?php
namespace Db;
return array(
    'doctrine' => array (
        'driver' => array (
            'db_entity' => array (
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array (
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array (
                'drivers' => array (
                    __NAMESPACE__ . '\Entity' => 'db_entity'
                )
            )
        ),
    ),
);