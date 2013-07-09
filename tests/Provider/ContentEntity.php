<?php

namespace Provider;
use Model\Entity\EntityAbstract;

/**
 * @mapper testMapper Provider\ContentMapper
 *
 * @validator Provider\ContentValidator Test error message.
 * @validator contentValidator          Test error message.
 */
class ContentEntity extends EntityAbstract
{
    public $id = [
        'type' => 'string'
    ];

    public $name = [
        'type' => 'string'
    ];

    public $user = [
        'type'  => 'has_one',
        'class' => 'Provider\UserEntity'
    ];

    public $comments = [
        'type'  => 'has_many',
        'class' => 'Provider\CommentEntity'
    ];

    public $references = [
        'type'     => 'has_many',
        'class'    => 'Provider\ReferenceEntity',
        'autoload' => 'ReferenceRepository::getByContentId'
    ];

    public static $validatedUsingClass = false;

    public static $validatedUsingMethod = false;

    public function contentValidator(self $content)
    {
        self::$validatedUsingMethod = true;
    }

    public function validateNameExists($name)
    {
        return $name ?: false;
    }

    protected function joinReferences() {
        return ReferenceRepository::getByContentId($this->id);
    }
}