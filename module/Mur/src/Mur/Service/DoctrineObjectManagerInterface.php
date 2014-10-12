<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 12/10/2014
 * Time: 19:25
 */

namespace Mur\Service;


interface DoctrineObjectManagerInterface
{
    public function getEntityManager();

    public function setEntityManager($entityManager);

    public function getHydrator();

    public function setHydrator($hydrator);

    public function hydrate($data, $entity);

    public function record($entity);

    public function delete($entity);

    public function update($data, $entity);

}