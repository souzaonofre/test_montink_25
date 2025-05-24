<?php

declare(strict_types=1);

namespace Onofre\TestMontink25\System\Http;

class ServerHttpFactory
{

    public static function createRequestFromGlobals(): HttpRequest
    {

        return new HttpRequest();
    }

    public static function createResponse(): HttpResponse
    {

        return new HttpResponse();
    }
}
