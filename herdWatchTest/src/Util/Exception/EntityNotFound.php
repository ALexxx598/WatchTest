<?php

namespace App\Util\Exception;

class EntityNotFound extends BaseException
{
    /**
     * @inheritdoc
     */
    protected $message = 'Entity not found.';

    /**
     * @var string|null
     */
    protected ?string $entity = null;

    public function __construct()
    {
        parent::__construct();

        if (!is_null($entity = $this->getEntity())) {
            $this->message = sprintf('%s not found.', $entity);
        }
    }

    /**
     * @return string|null
     */
    public function getEntity(): ?string
    {
        return $this->entity;
    }
}
