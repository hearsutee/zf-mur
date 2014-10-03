<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 03/10/2014
 * Time: 11:25
 */

namespace Mur\Form;

use Zend\InputFilter\InputFilter;

class MessageFilter extends InputFilter
{
    public function __construct()
    {
        // self::__construct(); // parnt::__construct(); - trows and error
        $this->add([
            'name' => 'content', // 'usr_name'
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 100,
                    ],
                ]
            ],
        ]);


    }
}