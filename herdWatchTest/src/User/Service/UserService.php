<?php

namespace App\User\Service;

use App\User\Exception\UserNotFoundException;
use App\User\Payload\UserCreatePayload;
use App\User\Payload\UserUpdatePayload;
use App\User\Repository\UserRepositoryInterface;
use App\User\User;
use App\User\UserCollection;
use App\User\UserFilter;

class UserService implements UserServiceInterface
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function list(UserFilter $filter): UserCollection
    {
        return $this->userRepository->list($filter);
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): User
    {
        $user = $this->userRepository->findById($id);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function create(UserCreatePayload $payload): User
    {
        $user = new User(
            name: $payload->getName(),
            email: $payload->getEmail(),
        );

        return $user->setId($this->userRepository->save($user));
    }

    /**
     * @inheritDoc
     */
    public function update(UserUpdatePayload $payload): User
    {
        $user = $this->getById($payload->getId());

        if ($payload->getEmail() !== null) {
            $user->setEmail($payload->getEmail());
        }

        if ($payload->getName() !== null) {
            $user->setName($payload->getName());
        }

        $this->userRepository->save($user);

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $this->userRepository->delete($id);
    }
}