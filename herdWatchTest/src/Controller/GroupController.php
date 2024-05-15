<?php

namespace App\Controller;

use App\Group\Exception\GroupNotFoundException;
use App\Group\GroupFilter;
use App\Group\Payload\GroupCreatePayload;
use App\Group\Payload\GroupUpdatePayload;
use App\Group\Request\GroupCreateRequest;
use App\Group\Request\GroupListRequest;
use App\Group\Request\GroupUpdateRequest;
use App\Group\Response\GroupListResponse;
use App\Group\Response\GroupResponse;
use App\Group\Service\GroupServiceInterface;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends AbstractController
{
    /**
     * @param GroupServiceInterface $groupService
     */
    public function __construct(
        private GroupServiceInterface $groupService
    ) {
    }

    #[Route(
        path: 'api/group/',
        methods: [Request::METHOD_GET]
    )]
    public function list(GroupListRequest $request): JsonResponse
    {
        $groups = $this->groupService->list(
            GroupFilter::make(
                groupsPage: $request->getGroupsPage(),
                groupsPerPage: $request->getGroupsPerPage(),
                usersPage: $request->getusersPage(),
                usersPerPage: $request->getusersPerPage(),
                withUsers: $request->getWithUsers(),
            )
        );

        GroupResponse::setWithUsers($request->getWithUsers());
        return new JsonResponse(GroupListResponse::make($groups));
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws GroupNotFoundException
     */
    #[Route(
        path: 'api/group/{id}',
        requirements: ['id' => '\d+'],
        methods: [Request::METHOD_GET]
    )]
    public function getById(int $id): JsonResponse
    {
        $group = $this->groupService->getById($id);

        return new JsonResponse([
            'data' => GroupResponse::make($group),
        ]);
    }

    /**
     * @param GroupCreateRequest $request
     * @return JsonResponse
     */
    #[Route(
        path: 'api/group/',
        methods: [Request::METHOD_POST]
    )]
    public function create(GroupCreateRequest $request): JsonResponse
    {
        $group = $this->groupService->create(
            GroupCreatePayload::make(
                name: $request->getName(),
            )
        );

        return new JsonResponse([
            'data' => GroupResponse::make($group),
        ]);
    }

    /**
     * @param GroupUpdateRequest $request
     * @return JsonResponse
     * @throws GroupNotFoundException
     */
    #[Route(
        path: 'api/group/{id}',
        requirements: ['id' => '\d+'],
        methods: [Request::METHOD_PATCH]
    )]
    public function update(GroupUpdateRequest $request): JsonResponse
    {
        $group = $this->groupService->update(
            GroupUpdatePayload::make(
                id: $request->getId(),
                name: $request->getName(),
            )
        );

        return new JsonResponse([
            'data' => GroupResponse::make($group),
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws ORMException
     */
    #[Route(
        path: 'api/group/{id}',
        requirements: ['id' => '\d+'],
        methods: [Request::METHOD_DELETE]
    )]
    public function delete(int $id): JsonResponse
    {
        $this->groupService->delete($id);

        return new JsonResponse([
            'status' => 200,
        ]);
    }
}