<?php

namespace App\User\Service;

use App\User\Exception\UserNotFoundException;
use App\User\Payload\UserCreatePayload;
use App\User\Payload\UserUpdatePayload;
use App\User\User;
use App\User\UserCollection;
use App\User\UserFilter;

interface UserServiceInterface
{
    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function getById(int $id): User;

    /**
     * @param UserCreatePayload $payload
     * @return User
     */
    public function create(UserCreatePayload $payload): User;

    /**
     * @param UserUpdatePayload $payload
     * @return User
     * @throws UserNotFoundException
     */
    public function update(UserUpdatePayload $payload): User;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * @param UserFilter $filter
     * @return UserCollection
     */
    public function list(UserFilter $filter): UserCollection;
}