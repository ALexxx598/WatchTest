<?php

namespace App\User\Service;

trait UserServiceFinderTrait
{
    /**
     * @var UserServiceInterface|null
     */
    private static ?UserServiceInterface $userService = null;

    /**
     * @var Closure|null
     */
    private static ?\Closure $userServiceResolver = null;

    /**
     * @param Closure|null $userServiceResolver
     */
    public static function setUserServiceResolver(?\Closure $userServiceResolver = null): void
    {
        static::$userService = null;

        static::$userServiceResolver = $userServiceResolver;
    }

    /**
     * @return UserServiceInterface
     */
    public function getUserService(): UserServiceInterface
    {
        return static::$userService ?? static::$userService = call_user_func(static::$userServiceResolver);
    }
}