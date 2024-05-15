<?php

namespace App\Group\Repository;

use App\Group\Group;
use App\Group\GroupCollection;
use App\Group\GroupFilter;
use Doctrine\ORM\Exception\ORMException;

interface GroupRepositoryInterface
{
    /**
     * @param Group $group
     * @param bool $flush
     * @return int
     */
    public function save(Group $group, bool $flush = true): int;

    /**
     * @param int $id
     * @return Group|null
     */
    public function findById(int $id): ?Group;

    /**
     * @param int $id
     * @param bool $flush
     * @return void
     * @throws ORMException
     */
    public function delete(int $id): void;

    /**
     * @param GroupFilter $filter
     * @return GroupCollection
     */
    public function list(GroupFilter $filter): GroupCollection;
}
