<?php

namespace App\Util;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use ReflectionClass;

abstract class BaseResponse implements BaseResponseInterface, JsonSerializable
{
    /**
     * @param object $object
     */
    private function __construct(
        private object $object,
    ) {
    }

    /**
     * @param object $object
     * @return static
     */
    final public static function make(object $object): static
    {
        return new static(object: $object);
    }

    /**
     * @param ArrayCollection<object> $collection
     * @return static
     */
    final public static function collection(ArrayCollection $collection): static
    {
        return new static(object: $collection);
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        if ($this->object instanceof ArrayCollection) {
            $collection = clone $this->object;

            return $collection->map(fn (object $object) => static::make($object)->toArray())->toArray();
        }

        $reflectionClass = new ReflectionClass($this);
        if (method_exists($this, 'toArray')
            && $reflectionClass->getMethod('toArray')->class !== self::class
        ) {
            return static::toArray();
        }

        if (method_exists($this->object, 'toArray')) {
            return $this->object->toArray();
        }

        return [];
    }

    /**
     * Dynamically pass method calls to the underlying resource.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->object->{$method}($parameters);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return self::toArray();
    }
}
