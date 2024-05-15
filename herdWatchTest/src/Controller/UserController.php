<?php

namespace App\Controller;

use App\User\Exception\UserNotFoundException;
use App\User\Payload\UserCreatePayload;
use App\User\Payload\UserUpdatePayload;
use App\User\Request\UserCreateRequest;
use App\User\Request\UserUpdateRequest;
use App\User\Response\UserResponse;
use App\User\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @param UserServiceInterface $userService
     */
    public function __construct(
        public UserServiceInterface $userService
    ) {
    }

    /**
     * @return JsonResponse
     */
    #[Route(path: '/', methods: [Request::METHOD_GET])]
    public function check()
    {
        return new JsonResponse([
            'data' => 'good',
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws \App\User\Exception\UserNotFoundException
     */
    #[Route(
        path: 'api/user/{id}',
        requirements: ['id' => '\d+'],
        methods: [Request::METHOD_GET]
    )]
    public function getById(int $id): JsonResponse
    {
        $user = $this->userService->getById($id);

        return new JsonResponse([
            'data' => UserResponse::make($user),
        ]);
    }

    /**
     * @param UserCreateRequest $request
     * @return JsonResponse
     */
    #[Route(path: 'api/user/', methods: [Request::METHOD_POST])]
    public function create(UserCreateRequest $request): JsonResponse
    {
        $user = $this->userService->create(
            UserCreatePayload::make(
                name: $request->getName(),
                email: $request->getEmail(),
            )
        );

        return new JsonResponse([
            'data' => UserResponse::make($user),
        ]);
    }

    /**
     * @param UserUpdateRequest $request
     * @return JsonResponse
     * @throws UserNotFoundException
     */
    #[Route(
        path: 'api/user/{id}',
        requirements: ['id' => '\d+'],
        methods: [Request::METHOD_PATCH]
    )]
    public function update(UserUpdateRequest $request): JsonResponse
    {
        $user = $this->userService->update(
            UserUpdatePayload::make(
                id: $request->getUserId(),
                name: $request->getName(),
                email: $request->getEmail(),
            )
        );

        return new JsonResponse([
            'data' => UserResponse::make($user),
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route(
        path: 'api/user/{id}',
        requirements: ['id' => '\d+'],
        methods: [Request::METHOD_DELETE]
    )]
    public function delete(int $id): JsonResponse
    {
        $this->userService->delete($id);

        return new JsonResponse([
            'status' => 200,
        ]);
    }
}