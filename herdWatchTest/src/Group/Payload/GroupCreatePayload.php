<?php

namespace App\Group\Payload;

class GroupCreatePayload
{
    /**
     * @param string $name
     */
    public function __construct(
        private string $name,
    ) {
    }

    /**
     * @param string $name
     * @return self
     */
    public static function make(string $name): self
    {
        return new self(
            name: $name,
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}