<?php

namespace App\Group;

class GroupFilter
{
    /**
     * @param int|null $groupsPage
     * @param int|null $groupsPerPage
     * @param int|null $usersPage
     * @param int|null $usersPerPage
     * @param bool|null $withUsers
     */
    public function __construct(
        private ?int $groupsPage = null,
        private ?int $groupsPerPage = null,
        private ?int $usersPage = null,
        private ?int $usersPerPage = null,
        private ?bool $withUsers = false,
    ) {
    }

    /**
     * @param int|null $groupsPage
     * @param int|null $groupsPerPage
     * @param int|null $usersPage
     * @param int|null $usersPerPage
     * @param bool|null $withUsers
     * @return self
     */
    public static function make(
        ?int $groupsPage = null,
        ?int $groupsPerPage = null,
        ?int $usersPage = null,
        ?int $usersPerPage = null,
        ?bool $withUsers = false,
    ): self {
        return new self(
            groupsPage: $groupsPage,
            groupsPerPage: $groupsPerPage,
            usersPage: $usersPage,
            usersPerPage: $usersPerPage,
            withUsers: $withUsers
        );
    }

    /**
     * @return int|null
     */
    public function getGroupsPage(): ?int
    {
        return $this->groupsPage;
    }

    /**
     * @return int|null
     */
    public function getGroupsPerPage(): ?int
    {
        return $this->groupsPerPage;
    }

    public function getUsersPage(): ?int
    {
        return $this->usersPage;
    }

    public function getUsersPerPage(): ?int
    {
        return $this->usersPerPage;
    }

    public function getWithUsers(): ?bool
    {
        return $this->withUsers;
    }
}