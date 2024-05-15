<?php

namespace App\Util;

use Doctrine\Common\Collections\ArrayCollection;

class AggregateCollection
{
    public function __construct(
        private ArrayCollection $items,
        private ?int $totalPages = null,
        private ?int $currentPage = null,
        private ?int $perPage = null
    ) {
    }

    public function getItems(): ArrayCollection
    {
        return $this->items;
    }

    /**
     * @return int|null
     */
    public function getTotalPages(): ?int
    {
        return $this->totalPages;
    }

    /**
     * @param int|null $totalPages
     * @return $this
     */
    public function setTotalPages(?int $totalPages): self
    {
        $this->totalPages = $totalPages;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCurrentPage(): ?int
    {
        return $this->currentPage;
    }

    /**
     * @param int|null $currentPage
     * @return $this
     */
    public function setCurrentPage(?int $currentPage): self
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    /**
     * @param int|null $perPage
     * @return $this
     */
    public function setPerPage(?int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }
}