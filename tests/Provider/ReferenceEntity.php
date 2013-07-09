<?php

namespace Provider;
use Model\Entity\EntityAbstract;

class ReferenceEntity extends EntityAbstract
{
    /**
     * @vo Model\Vo\String
     */
    public $id;

    /**
     * @vo Model\Vo\String
     */
    public $contentId;

    /**
     * @vo Model\Vo\String
     */
    public $description;

    /**
     * @vo Model\Vo\String
     */
    public $link = 'http://google.com';
}