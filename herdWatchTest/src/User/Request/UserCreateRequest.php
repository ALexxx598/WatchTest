<?php

namespace App\User\Request;

use App\Util\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class UserCreateRequest extends BaseRequest
{
    /**
     * @var string
     */
    #[Assert\NotNull]
    #[Assert\Type('string')]
    #[Assert\Length(min: 2, max: 255)]
    protected $name;

    /**
     * @var string
     */
    #[Assert\NotNull]
    #[Assert\Type('string')]
    #[Assert\Length(min: 7, max: 255)]
    #[Assert\Email]
    protected $email;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}