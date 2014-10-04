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

    public function write(array $data)
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $message = new Message();

        $hydrator = new DoctrineObject($em);
        $hydrator->hydrate($data, $message);

        $virtualUser = new User();

        //temp, quand auth fonctionnera recuperer l'utilisateur connecté !
        $virtualUser->setId(654654)
            ->setUserName('Temp-Test')
             ->setPassword('Temp-Test123')
             ->setRole('member');
        $em->persist($virtualUser);

        $message->setUser($virtualUser);

        $message->setDateCreation(new \DateTime('now'));

        $em->persist($message);
        $em->flush();

        return true;
    }
} 