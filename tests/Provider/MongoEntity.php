<?php

namespace Provider;
use Model\Entity\EntityAbstract;

/**
 * @filter to mongoId using Model\Filter\Generic\RemoveMongoId.
 */
class MongoEntity extends EntityAbstract
{
    /**
     * @vo Model\Vo\String
     */
    public $_id;

}
