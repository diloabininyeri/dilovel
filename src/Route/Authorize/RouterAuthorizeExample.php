<?php


namespace App\Routers\Authorize;

use App\Interfaces\RouterAuthorizeInterface;

class RouterAuthorizeExample implements RouterAuthorizeInterface
{
    public function isAuthorize(): bool
    {
        return false;
    }
}
