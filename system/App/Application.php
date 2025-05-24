<?php

declare(strict_types=1);

namespace Onofre\TestMontink25\System\App;

use Onofre\TestMontink25\System\Http\HttpRequest;
use Onofre\TestMontink25\System\Http\HttpResponse;
use stdClass;

class Application
{
    protected object $request;
    protected object $response;
    protected object $dispatcher;

    protected string $basePath;
    protected string $publicPath;
    protected string $appPath;

    protected string $urlPath;
    protected string $urlQuery;
    protected array $urlParams;

    protected array $responseData;

    public function __construct(?string $basePath = null, ?string $publicPath = null, ?string $appPath = null)
    {
        $this->basePath = $basePath ?? BASE_DIR;
        $this->publicPath = $publicPath ?? PUBLIC_DIR;
        $this->appPath = $appPath ?? APP_DIR;

        $this->urlPath = '/';
        $this->urlQuery = '';
        $this->urlParams = [];

        $this->responseData = [];
    }

    public function setRequest(HttpRequest $request): Application
    {
        $this->request = $request;


        return $this;
    }

    public function setResponse(HttpResponse $response): Application
    {
        $this->response = $response;


        return $this;
    }

    public function setDispacther(Dispatcher $dispatcher): Application
    {
        $this->dispatcher = $dispatcher;


        return $this;
    }

    public function dispatch(): Dispatcher
    {
        return $this->dispatcher;
    }


    public function set(string $key, mixed $value): Application
    {
        return $this;
    }


    public function get(string $key): object
    {
        return new stdClass;
    }
}
