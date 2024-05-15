<?php

namespace App\Group\Response;

use App\Group\GroupCollection;
use App\Util\BaseResponse;

/**
 * @mixin GroupCollection
 */
class GroupListResponse extends BaseResponse
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => GroupResponse::collection($this->getItems()),
            'temp' => [
                'totalItems' => $this->getItems()->count(),
                'totalPages' => $this->getTotalPages(),
                'currentPage' => $this->getCurrentPage(),
                'perPage' => $this->getPerPage(),
            ]
        ];
    }
}