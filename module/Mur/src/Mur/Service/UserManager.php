<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 03/10/2014
 * Time: 16:03
 */

namespace Mur\Service;


use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Mur\Entity\Message;
use Mur\Entity\User;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class MessageManager implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function create(array $data)
    {
        $sm = $this->getServiceLocator();

        $em = $sm->get('doctrine.entitymanager.orm_default');

        $user = new User();

        $hydrator = new DoctrineObject($em);
        $hydrator->hydrate($data, $user);

        $em->persist($user);
        $em->flush();

        return true;
    }
} 