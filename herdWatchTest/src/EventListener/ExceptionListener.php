<?php

namespace App\EventListener;

use App\Group\Exception\GroupNotFoundException;
use App\User\Exception\UserNotFoundException;
use App\Util\Exception\ErrorCodes;
use App\Util\Exception\ValidationException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

class ExceptionListener
{
    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        $response = match (true) {
            $e instanceof ValidationException => $this->mapValidationException($e),
            $e instanceof UserNotFoundException => $this->mapUserEntityNotFound($e),
            $e instanceof GroupNotFoundException => $this->mapGroupEntityNotFound($e),
            default => $this->mapDefault($e),
        };

        $event->setResponse($response);
    }

    /**
     * @param Exception|Throwable $e
     * @return JsonResponse
     */
    private function mapDefault(Exception|Throwable $e): JsonResponse
    {
        return new JsonResponse(
            data: [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ],
            status: Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * @param ValidationException $e
     * @return JsonResponse
     */
    private function mapValidationException(ValidationException $e): JsonResponse
    {
        return new JsonResponse(
            data: [
                'message' => $e->getMessage(),
                'errors' => $e->getErrors(),
                'error' => ErrorCodes::VALIDATION_EXCEPTION()->label,
                'code' => ErrorCodes::VALIDATION_EXCEPTION,
            ],
            status: Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param UserNotFoundException $e
     * @return JsonResponse
     */
    private function mapUserEntityNotFound(UserNotFoundException $e): JsonResponse
    {
        return new JsonResponse(
            data: [
                'message' => $e->getMessage(),
                'error' => ErrorCodes::USER_NOT_FOUND()->label,
                'code' => ErrorCodes::USER_NOT_FOUND(),
            ],
            status: Response::HTTP_BAD_REQUEST,
        );
    }

    private function mapGroupEntityNotFound(GroupNotFoundException $e): JsonResponse
    {
        return new JsonResponse(
            data: [
                'message' => $e->getMessage(),
                'error' => ErrorCodes::GROUP_NOT_FOUND()->label,
                'code' => ErrorCodes::GROUP_NOT_FOUND(),
            ],
            status: Response::HTTP_BAD_REQUEST,
        );
    }
}
