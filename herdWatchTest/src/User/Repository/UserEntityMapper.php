<?php

namespace App\User\Repository;

use App\Entity\User as UserEntity;
use App\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class UserEntityMapper
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param User $user
     * @return UserEntity
     */
    public function mapAggregateToEntity(User $user): UserEntity
    {
        $entity = $this->entityManager->getUnitOfWork()->tryGetById(
            id: $user->getId(),
            rootClassName: UserEntity::class
        );

        if ($entity instanceof UserEntity) {
            return $entity
                ->setName($user->getName())
                ->setEmail($user->getEmail());
        }

        return (new UserEntity())
            ->setId($user->getId())
            ->setName($user->getName())
            ->setEmail($user->getEmail());
    }

    /**
     * @param UserEntity $entity
     * @return User
     */
    public function mapEntityToAggregate(UserEntity $entity): User
    {
        return new User(
            id: $entity->getId(),name: $entity->getName(),email: $entity->getEmail(),
        );
    }

    /**
     * @param ArrayCollection $entities
     * @return ArrayCollection
     */
    public function mapEntitiesToAggregates(ArrayCollection $entities): ArrayCollection
    {
        return $entities->map(fn (UserEntity $user) => $this->mapEntityToAggregate($user));
    }
}