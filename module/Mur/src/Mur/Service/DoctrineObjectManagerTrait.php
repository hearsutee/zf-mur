<?php
/**
 * Created by PhpStorm.
 * User: Manu
 * Date: 12/10/2014
 * Time: 19:34
 */

namespace Mur\Service;


trait DoctrineObjectManagerTrait
{
    protected $hydrator;
    protected $entityManager;

    /**
     * @param array $data
     * @param $entity
     * @return bool
     */
    public function update($data, $entity)
    {

        $this->hydrate($data, $entity);
        $this->record($entity);

        return true;
    }


    /**
     * @param $entity
     * @return bool
     */
    public function delete($entity)
    {
        $em = $this->getEntityManager();

        $em->remove($entity);
        $em->flush();

        return true;
    }


    /**
     * @param $entity
     * @return bool
     */
    public function record($entity)
    {
        $em = $this->getEntityManager();

        $em->persist($entity);
        $em->flush();

        return true;
    }

    /**
     * @param array $data
     * @param $entity
     */
    public function hydrate($data, $entity)
    {

        $hydrator = $this->getHydrator();
        $hydrator->hydrate($data, $entity);

    }

    public function getHydrator()
    {
        return $this->hydrator;
    }

    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }


    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
} 