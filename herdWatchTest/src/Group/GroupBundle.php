<?php

namespace App\Group;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GroupBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function boot()
    {
        parent::boot();

        Group::setUserServiceResolver(function () {
            return $this->container->get('app.user_service');
        });
    }
}
