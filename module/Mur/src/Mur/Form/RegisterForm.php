<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 03/10/2014
 * Time: 10:19
 */

namespace Mur\Form;


use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('register');

//       $this->init();
    }

    public function init()
    {
        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'userName',
            'attributes' => [
                'type' => 'text',
            ],
            'options' => [
                'label' => 'userName',
            ],
        ]);
        $this->add([
            'name' => 'password',
            'attributes' => [
                'type' => 'text',
            ],
            'options' => [
                'label' => 'password ',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Register',
                'id' => 'submitbutton',
            ],
        ]);
    }
} 