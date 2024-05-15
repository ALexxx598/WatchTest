<?php

namespace App\Group\Exception;

use Exception;

class GroupNotFoundException extends Exception
{
    protected $message = 'Group not found';
}