<?php

namespace App\User\Repository;

use App\Entity\User as UserEntity;
use App\User\User;
use App\User\UserCollection;
use App\User\UserFilter;
use App\Util\TotalItemsFinder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    use TotalItemsFinder;

    private const ENTITY_ALIAS = 'u';

    /**
     * @param ManagerRegistry $registry
     * @param UserEntityMapper $entityMapper
     */
    public function __construct(
        ManagerRegistry $registry,
        private UserEntityMapper $entityMapper,
    ) {
        parent::__construct($registry, UserEntity::class);
    }

    public function list(UserFilter $filter): UserCollection
    {
        $query = $this->mapFilterToQuery($filter);
        $totalPages = $this->getTotalPages($query, $filter->getPerPage());

        $entities = $this
            ->setQueryPaginationParams(
                queryBuilder: $query,
                perPage: $filter->getPerPage(),
                page: $filter->getPage()
            )
            ->getQuery()
            ->getResult();

        return new UserCollection(
            items: $this->entityMapper->mapEntitiesToAggregates(new ArrayCollection($entities)),
            totalPages: $totalPages,
            currentPage: $filter->getPage(),
            perPage: $filter->getPerPage()
        );
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?User
    {
        $user = $this->find($id);

        return !is_null($user) ? $this->entityMapper->mapEntityToAggregate($user) : $user;
    }

    /**
     * @inheritDoc
     */
    public function save(User $user, bool $flush = true): int
    {
        $entity = $this->entityMapper->mapAggregateToEntity($user);
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $entity->getId();
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id, bool $flush = true): void
    {
        /*** @var UserEntity|null $user */
        $user = $this->getEntityManager()->getRepository(UserEntity::class)->find($id);

        if ($user === null) {
            return;
        }

        $this->getEntityManager()->remove($user);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    private function mapFilterToQuery(UserFilter $filter): QueryBuilder
    {
        $query = $this->createQueryBuilder(self::ENTITY_ALIAS);

        if ($filter->getPage() !== null) {
            $query
                ->leftJoin('g.users', 'u')
                ->where('u.id = g.id')
                ->setMaxResults($filter->getPerPage())
                ->setFirstResult($filter->getPerPage() * ($filter->getPage() - 1));
        }

        return $query;
    }
}