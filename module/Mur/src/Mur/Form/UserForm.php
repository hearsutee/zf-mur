<?php
namespace Mur\Form;

use Zend\Form\Form;
use ZFTest\Hal\TestAsset\ClassMethods;


class UserForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('user');
        $this->setHydrator(new ClassMethods());

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
            'name' => 'isAdmin',
            'attributes' => [
                'type' => 'text',
            ],
            'options' => [
                'label' => 'is admin ?',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Save user',
                'id' => 'submitbutton',
            ],
        ]);
    }
}