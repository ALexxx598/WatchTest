<?php

namespace App\Group\Payload;

class GroupUpdatePayload
{
    /**
     * @param int $id
     * @param string|null $name
     */
    public function __construct(
        private int $id,
        private ?string $name = null,
    ) {
    }

    /**
     * @param int $id
     * @param string|null $name
     * @return self
     */
    public static function make(int $id, ?string $name = null): self
    {
        return new self(
            id: $id,
            name: $name,
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}