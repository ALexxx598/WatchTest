<?php

namespace App\User\Repository;

use App\User\User;
use App\User\UserCollection;
use App\User\UserFilter;
use Doctrine\ORM\Exception\ORMException;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @param bool $flush
     * @return int
     */
    public function save(User $user, bool $flush = true): int;

    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * @param int $id
     * @param bool $flush
     * @return void
     * @throws ORMException
     */
    public function delete(int $id);

    /**
     * @param UserFilter $filter
     * @return UserCollection
     */
    public function list(UserFilter $filter): UserCollection;
}