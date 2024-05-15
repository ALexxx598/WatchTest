<?php

namespace App\Group\Request;

use App\Util\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class GroupListRequest extends BaseRequest
{
    private const USERS_PER_PAGE = 10;

    private const USERS_PAGE = 1;

    private const GROUPS_PER_PAGE = 10;

    private const GROUPS_PAGE = 1;

    #[Assert\Type(type: 'integer')]
    protected $groupsPage;

    #[Assert\Type(type: 'integer')]
    protected $groupsPerPage;

    #[Assert\Type(type: 'integer')]
    protected $usersPage;

    #[Assert\Type(type: 'integer')]
    protected $usersPerPage;

    #[Assert\Type(type: 'bool')]
    protected $withUsers;

    /**
     * @return int
     */
    public function getUsersPage(): int
    {
        return $this->usersPage ?? self::USERS_PAGE;
    }

    /**
     * @return int
     */
    public function getUsersPerPage(): int
    {
        return $this->usersPerPage ?? self::USERS_PER_PAGE;
    }

    /**
     * @return int
     */
    public function getGroupsPage(): int
    {
        return $this->groupsPage ?? self::GROUPS_PAGE;
    }

    /**
     * @return int
     */
    public function getGroupsPerPage(): int
    {
        return $this->groupsPerPage ?? self::GROUPS_PER_PAGE;
    }

    /**
     * @return bool
     */
    public function getWithUsers(): bool
    {
        return $this->withUsers ?? true;
    }
}