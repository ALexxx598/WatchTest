<?php

namespace App\Util;

use Doctrine\Common\Collections\ArrayCollection;

interface BaseResponseInterface
{
    /**
     * @param object $object
     * @return static
     */
    public static function make(object $object): static;

    /**
     * @param ArrayCollection $collection
     */
    public static function collection(ArrayCollection $collection): static;

    /**
     * @return array
     */
    public function toArray(): array;
}
