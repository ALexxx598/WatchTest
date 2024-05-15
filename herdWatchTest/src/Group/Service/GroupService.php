<?php

namespace App\Group\Service;

use App\Group\Exception\GroupNotFoundException;
use App\Group\Group;
use App\Group\GroupCollection;
use App\Group\GroupFilter;
use App\Group\Payload\GroupCreatePayload;
use App\Group\Payload\GroupUpdatePayload;
use App\Group\Repository\GroupRepositoryInterface;

class GroupService implements GroupServiceInterface
{
    /**
     * @param GroupRepositoryInterface $groupRepository
     */
    public function __construct(private GroupRepositoryInterface $groupRepository)
    {}

    /**
     * @inheritDoc
     */
    public function getById(int $id): Group
    {
        $group = $this->groupRepository->findById($id);

        if ($group === null) {
            throw new GroupNotFoundException();
        }

        return $group;
    }

    public function list(GroupFilter $filter): GroupCollection
    {
        return $this->groupRepository->list($filter);
    }

    /**
     * @inheritDoc
     */
    public function create(GroupCreatePayload $payload): Group
    {
        $group = new Group(
            name: $payload->getName(),
        );

        return $group->setId($this->groupRepository->save($group));
    }

    /**
     * @inheritDoc
     */
    public function update(GroupUpdatePayload $payload): Group
    {
        $group = $this->getById($payload->getId());

        if ($payload->getName() !== null) {
            $group->setName($payload->getName());
        }

        $this->groupRepository->save($group);

        return $group;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $this->groupRepository->delete($id);
    }
}