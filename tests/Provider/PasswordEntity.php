<?php

namespace Provider;
use Model\Entity\EntityAbstract;

/**
 * @filter to noPassword using Model\Filter\Generic\RemovePassword.
 */
class PasswordEntity extends EntityAbstract
{
    /**
     * @vo Model\Vo\String
     */
    public $password;

}
