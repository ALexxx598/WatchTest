<?php

namespace App\User\Request;

use App\Util\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class UserUpdateRequest extends BaseRequest
{
    #[Assert\NotNull]
    #[Assert\Type(type: 'integer')]
    protected int $userId;

    #[Assert\Type(type: 'string')]
    #[Assert\Length(min: 2, max: 255)]
    protected string $name;

    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    #[Assert\Length(min: 7, max: 255)]
    #[Assert\Email]
    protected string $email;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
}