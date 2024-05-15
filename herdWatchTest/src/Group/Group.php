<?php

namespace App\Group;

use App\User\Service\UserServiceFinderTrait;
use App\User\UserCollection;
use App\User\UserFilter;

class Group
{
    use UserServiceFinderTrait;

    /**
     * @param string|null $id
     * @param string $name
     * @param UserCollection|null $users
     */
    public function __construct(
        private ?string $id = null,
        private string $name,
        private ?UserCollection $users = null,
    ) {
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return $this
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return UserCollection
     */
    public function getUsers(): UserCollection
    {
        return $this->users ?? $this->users = $this->getUserService()->list(UserFilter::make(groupId: $this->id));
    }

    /**
     * @param UserCollection|null $users
     * @return Group
     */
    public function setUsers(?UserCollection $users = null): self
    {
        $this->users = $users;

        return $this;
    }
}