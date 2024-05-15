<?php

namespace App\User;

class UserFilter
{
    /**
     * @param int|null $groupId
     * @param int|null $perPage
     * @param int|null $page
     */
    public function __construct(
        private ?int $groupId = null,
        private ?int $perPage = null,
        private ?int $page = null,
    ) {
    }

    /**
     * @param int|null $groupId
     * @param int|null $perPage
     * @param int|null $page
     * @return self
     */
    public static function make(?int $groupId = null, ?int $perPage = null, ?int $page = null): self
    {
        return new self(
            groupId: $groupId,
            perPage: $perPage,
            page: $page
        );
    }

    /**
     * @return int|null
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }
}