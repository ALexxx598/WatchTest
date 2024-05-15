<?php

namespace App\User\Payload;

class UserCreatePayload
{
    /**
     * @param string $name
     * @param string $email
     */
    private function __construct(
        private string $name,
        private string $email,
    ) {
    }

    /**
     * @param string $name
     * @param string $email
     * @return self
     */
    public static function make(
        string $name,
        string $email,
    ): self {
            return new self(
            name: $name,email: $email
        );
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
}