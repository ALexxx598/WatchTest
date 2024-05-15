<?php

namespace App\Util\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class BaseException extends HttpException
{
    protected $message = 'Bad request.';

    public function __construct(int $statusCode = Response::HTTP_BAD_REQUEST) {
        parent::__construct(statusCode: $statusCode, message: $this->message);
    }
}
