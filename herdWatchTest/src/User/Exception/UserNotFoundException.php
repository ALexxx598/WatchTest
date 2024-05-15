<?php

namespace App\User\Exception;

class UserNotFoundException extends \Exception
{
    protected $message = 'User not found';
}