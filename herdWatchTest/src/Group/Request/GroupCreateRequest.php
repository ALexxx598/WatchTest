<?php

namespace App\Group\Request;

use App\Util\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class GroupCreateRequest extends BaseRequest
{
    #[Assert\Type(type: 'string')]
    #[Assert\Length(min: 2, max: 255)]
    protected $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}