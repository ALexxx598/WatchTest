<?php

namespace App\Group\Repository;

use App\Entity\Group as GroupEntity;
use App\Group\Group;
use App\Group\GroupCollection;
use App\Group\GroupFilter;
use App\User\Repository\UserEntityMapper;
use App\User\UserCollection;
use App\Util\TotalItemsFinder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class GroupRepository extends ServiceEntityRepository implements GroupRepositoryInterface
{
    use TotalItemsFinder;

    private const ENTITY_ALIAS = 'g';

    /**
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $entityManager
     * @param UserEntityMapper $userEntityMapper
     */
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $entityManager,
        private UserEntityMapper $userEntityMapper,
    ) {
        parent::__construct($registry, GroupEntity::class);
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Group
    {
        $group = $this->find($id);

        return !is_null($group) ? $this->mapEntityToAggregate($group) : $group;
    }

    /**
     * @param GroupFilter $filter
     * @return GroupCollection
     */
    public function list(GroupFilter $filter): GroupCollection
    {
        $query = $this->mapFilterToQuery($filter);
        $totalPages = $this->getTotalPages($query, $filter->getGroupsPerPage());

        $entities = $this
            ->setQueryPaginationParams(
                queryBuilder: $query,
                perPage: $filter->getGroupsPerPage(),
                page: $filter->getGroupsPage()
            )
            ->getQuery()
            ->getResult();

        return new GroupCollection(
            items: $this->mapEntitiesToAggregates(entities: new ArrayCollection($entities), filter: $filter),
            totalPages: $totalPages,
            currentPage: $filter->getGroupsPage(),
            perPage: $filter->getGroupsPerPage()
        );
    }

    /**
     * @param Group $group
     * @param bool $flush
     * @return int
     */
    public function save(Group $group, bool $flush = true): int
    {
        $entity = $this->mapAggregateToEntity($group);
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
        /*** @var GroupEntity|null $user */
        $group = $this->getEntityManager()->getRepository(GroupEntity::class)->find($id);

        if ($group === null) {
            return;
        }

        $group->getUsers()->clear();

        $this->getEntityManager()->remove($group);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Group $group
     * @return GroupEntity
     */
    private function mapAggregateToEntity(Group $group): GroupEntity
    {
        $entity = $this->entityManager->getUnitOfWork()->tryGetById(
            id: $group->getId(),
            rootClassName: GroupEntity::class
        );

        if ($entity instanceof GroupEntity) {
            return $entity
                ->setName($group->getName());
        }

        return (new GroupEntity())
            ->setId($group->getId())
            ->setName($group->getName());
    }

    /**
     * @param GroupEntity $entity
     * @param GroupFilter|null $filter
     * @return Group
     */
    private function mapEntityToAggregate(GroupEntity $entity, ?GroupFilter $filter = null): Group
    {
        $group = new Group(
            id: $entity->getId(),
            name: $entity->getName(),
        );

        if ($filter->getWithUsers()) {
            $group->setUsers(
                new UserCollection(
                    items: $this->userEntityMapper->mapEntitiesToAggregates(
                        new ArrayCollection($entity->getUsers()->toArray())
                    ),
                    currentPage: $filter->getUsersPage(),
                    perPage: $filter->getUsersPerPage()
                ),
            );
        }


        return $group;
    }

    /**
     * @param ArrayCollection $entities
     * @param GroupFilter|null $filter
     * @return ArrayCollection
     */
    private function mapEntitiesToAggregates(ArrayCollection $entities, ?GroupFilter $filter = null): ArrayCollection
    {
        return $entities->map(fn (GroupEntity $group) => $this->mapEntityToAggregate($group, $filter));
    }

    /**
     * @param GroupFilter $filter
     * @return QueryBuilder
     */
    private function mapFilterToQuery(GroupFilter $filter): QueryBuilder
    {
        $query = $this->createQueryBuilder(self::ENTITY_ALIAS)->select(self::ENTITY_ALIAS);

        if ($filter->getWithUsers() && $filter->getUsersPage() !== null) {
            $query
                ->leftJoin('g.users', 'u')
                ->addSelect('u')
                ->setMaxResults($filter->getUsersPerPage())
                ->setFirstResult($filter->getUsersPerPage() * ($filter->getUsersPage() - 1));
        }

        return $query;
    }
}