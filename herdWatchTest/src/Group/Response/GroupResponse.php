<?php

namespace App\Group\Response;

use App\Group\Group;
use App\User\Response\UserListResponse;
use App\User\Response\UserResponse;
use App\Util\BaseResponse;

/**
 * @mixin Group
 */
class GroupResponse extends BaseResponse
{
    private static bool $withUsers = false;

    public static function setWithUsers(bool $withUsers = false): bool
    {
        return static::$withUsers = $withUsers;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'users' => static::$withUsers ? UserListResponse::make($this->getUsers()) : null,
        ];
    }
}