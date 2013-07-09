<?php

namespace Provider\Benchmark;
use Model\Entity\EntityAbstract;

class Address extends EntityAbstract
{
    /**
     * @vo Model\Vo\String
     *
     * @validator Provider\Validator\Required
     */
    public $street;

    /**
     * @vo Model\Vo\String
     *
     * @validator Provider\Validator\Required
     */
    public $city;

    /**
     * @vo Model\Vo\String
     *
     * @validator Provider\Validator\Required
     */
    public $state;

    /**
     * @vo Model\Vo\String
     *
     * @validator Provider\Validator\Postcode
     */
    public $postcode;

    /**
     * @vo Model\Vo\Enum ['USA', 'Australia']
     *
     * @validator Provider\Validator\Required
     */
    public $country;
}