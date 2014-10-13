<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 02/10/2014
 * Time: 09:11
 */

namespace Mur\Repository;


use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository
{
    public function findAllOrderByDate()
    {
        return $this->_em->createQueryBuilder()
            ->select('m')
            ->from('Mur\Entity\Message', 'm')
            ->orderBy('m.dateCreation','DESC')
            ->getQuery()
            ->getResult();
    }
} 