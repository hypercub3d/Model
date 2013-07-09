<?php

namespace Model\Validator;

interface ValidatableInterface
{
    public function assert();

    public function validate();
}