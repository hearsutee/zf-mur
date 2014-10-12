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

    public function setEntityManager();

    public function getHydrator();

    public function setHydrator();

    public function hydrate();

    public function record();

    public function delete();

    public function update();


} 