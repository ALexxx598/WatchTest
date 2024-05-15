<?php

namespace App\User\Response;
use App\User\User;
use App\Util\BaseResponse;

/**
 * @mixin User
 */
class UserResponse extends BaseResponse
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
        ];
    }
}