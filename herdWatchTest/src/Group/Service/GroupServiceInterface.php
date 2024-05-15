<?php

namespace App\Group\Service;

use App\Group\Exception\GroupNotFoundException;
use App\Group\Group;
use App\Group\GroupCollection;
use App\Group\GroupFilter;
use App\Group\Payload\GroupCreatePayload;
use App\Group\Payload\GroupUpdatePayload;

interface GroupServiceInterface
{
    /**
     * @param GroupCreatePayload $payload
     * @return Group
     */
    public function create(GroupCreatePayload $payload): Group;

    /**
     * @param GroupUpdatePayload $payload
     * @return Group
     * @throws GroupNotFoundException
     */
    public function update(GroupUpdatePayload $payload): Group;

    /**
     * @param int $id
     * @return void
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function delete(int $id): void;

    /**
     * @param int $id
     * @return Group
     * @throws GroupNotFoundException
     */
    public function getById(int $id);

    /**
     * @param GroupFilter $filter
     * @return GroupCollection
     */
    public function list(GroupFilter $filter): GroupCollection;
}