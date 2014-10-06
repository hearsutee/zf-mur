<?php
namespace MurApi\V1\Rest\MurRest;

class MurRestResourceFactory
{
    public function __invoke($services)
    {
        return new MurRestResource();


    }
}
