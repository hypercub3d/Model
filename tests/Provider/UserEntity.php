<?php

namespace Provider;
use Model\Entity\EntityAbstract;

class UserEntity extends EntityAbstract
{
    /**
     * Returns whether or not this is the last administrator.
     *
     * @autoload autoloadIsLastAdministrator
     *
     * @vo Model\Vo\Boolean
     */
    public $isLastAdministrator;

    public function getContent()
    {
        return (new UserRepository)->getContent();
    }

    public function autoloadIsLastAdministrator()
    {
        return (new UserRepository)->isLastAdministrator();
    }
}