<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 03/10/2014
 * Time: 11:21
 */

namespace Mur\Form;


use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {

        parent::__construct('login');

    }

    public function init()
    {
        $this->setAttribute('method', 'post');
        /*
		$this->add(array(
            'name' => 'usr_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
		*/
        $this->add([
            'name' => 'username', // 'usr_name',
            'attributes' => [
                'type' => 'text',
            ],
            'options' => [
                'label' => 'Username',
            ],
        ]);
        $this->add([
            'name' => 'password', // 'usr_password',
            'attributes' => [
                'type' => 'password',
            ],
            'options' => [
                'label' => 'Password',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Login',
                'id' => 'submitbutton',
            ],
        ]);
    }
}