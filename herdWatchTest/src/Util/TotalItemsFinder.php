<?php

namespace App\Util;

use Doctrine\ORM\QueryBuilder;

trait TotalItemsFinder
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param int|null $perPage
     * @return int
     */
    private function getTotalPages(QueryBuilder $queryBuilder, ?int $perPage = null): int
    {
        $query = clone $queryBuilder;

        if (empty($perPage)) {
            return 1;
        }

        return ceil($this->getCount($query) / $perPage);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @return int
     */
    private function getCount(QueryBuilder $queryBuilder): int
    {
        return $queryBuilder
            ->select($queryBuilder->expr()->countDistinct(self::ENTITY_ALIAS))
            ->getQuery()
            ->getResult()[0][1];
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param int|null $perPage
     * @param int|null $page
     * @return QueryBuilder
     */
    private function setQueryPaginationParams(
        QueryBuilder $queryBuilder,
        ?int $perPage = null,
        ?int $page = null
    ): QueryBuilder {
        if (empty($perPage) || empty($page)) {
            return $queryBuilder;
        }

        return $queryBuilder
            ->setMaxResults($perPage)
            ->setFirstResult($perPage * ($page - 1));
    }
}
