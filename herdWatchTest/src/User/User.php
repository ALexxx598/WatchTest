<?php

namespace App\User;

use App\Group\GroupCollection;

class User
{
    /**
     * @param int|null $id
     * @param string $name
     * @param string $email
     * @param GroupCollection|null $groupCollection
     */
    public function __construct(
        private ?int $id = null,
        private string $name,
        private string $email,
        private ?GroupCollection $groupCollection = null,
    ) {
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return GroupCollection|null
     */
    public function getGroupCollection(): ?GroupCollection
    {
        return $this->groupCollection;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
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
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}