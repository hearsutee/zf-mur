<?php
namespace Mur\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;


class MessageForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('message');
        $this->setHydrator(new ClassMethods());

    }

    public function init()
    {
        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'content',
            'attributes' =>
                [
                    'type' => 'Zend\Form\Element\Textarea',
                ],
            'options' =>
                [
                    'label' => 'message :',
                ],
        ]);
        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Send message !',
                'id' => 'submitbutton',
            ],
        ]);
    }
}