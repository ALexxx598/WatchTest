<?php

namespace App\Group\Request;

use App\Util\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class GroupUpdateRequest extends BaseRequest
{
    #[Assert\NotNull]
    #[Assert\Type(type: 'integer')]
    protected int $id;

    #[Assert\Type(type: 'string')]
    #[Assert\Length(min: 2, max: 255)]
    protected $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}