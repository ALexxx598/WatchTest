<?php

namespace App\User\Response;

use App\User\UserCollection;
use App\Util\BaseResponse;

/**
 * @mixin UserCollection
 */
class UserListResponse extends BaseResponse
{
    public function toArray(): array
    {
        return [
            'data' => UserResponse::collection($this->getItems()),
            'temp' => [
                'totalItems' => $this->getItems()->count(),
                'totalPages' => $this->getTotalPages(),
                'currentPage' => $this->getCurrentPage(),
                'perPage' => $this->getPerPage(),
            ]
        ];
    }
}