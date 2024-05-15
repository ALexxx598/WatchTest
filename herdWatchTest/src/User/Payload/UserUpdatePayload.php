<?php

namespace App\User\Payload;

class UserUpdatePayload
{
    /**
     * @param int $id
     * @param string|null $name
     * @param string|null $email
     */
    private function __construct(
        private int $id,
        private ?string $name = null,
        private ?string $email = null,
    ) {
    }

    /**
     * @param int $id
     * @param string|null $name
     * @param string|null $email
     * @return self
     */
    public static function make(
        int $id,
        ?string $name = null,
        ?string $email = null,
    ): self {
        return new self(
            id: $id, name: $name, email: $email
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
}