<?php

declare(strict_types=1);

namespace Onofre\TestMontink25\System\App;

use Psr\Container\ContainerInterface;

use Onofre\TestMontink25\System\Exception\NotFoundException;
use Onofre\TestMontink25\System\Exception\ContainerException;

class Container implements ContainerInterface
{
    protected array $container_storage = [];


    /**
     * __construct function
     *
     * @param array|null $container_data
     */
    public function __construct(?array $container_data)
    {
        if (is_array($container_data)) {
            $this->merge($container_data);
        } else {
            $this->container_storage = [];
        }
    }

    /**
     * merge function
     *
     * @param array $container_data
     *
     * @throws ContainerException
     *
     * @return static
     */
    public function merge(array $container_data): static
    {
        try {
            $this->container_storage = array_merge($this->container_storage, $container_data);
            return $this;
        } catch (\Throwable $th) {
            throw new ContainerException($th->getMessage(), 500);
        }
    }

    /**
     * set function
     *
     * @param mixed $container_data
     *
     * @throws ContainerException
     *
     * @return static
     */
    public function set(string $key, mixed $container_object): static
    {
        try {
            $this->container_storage[$key] = $container_object;
            return $this;
        } catch (\Throwable $th) {
            throw new ContainerException($th->getMessage(), 500);
        }
    }


    /**
     * get function
     *
     * @param string $id
     *
     * @throws NotFoundException
     * @throws ContainerException
     *
     * @return mixed
     */
    public function get(string $id, mixed $default = null): mixed
    {
        if (!$this->has($id)) {
            throw new NotFoundException("Object not found in container storage", 500);
        }

        try {
            return $this->container_storage[$id] ?? $default;
        } catch (\Throwable $th) {
            throw new ContainerException($th->getMessage(), 500);
        }
    }

    /**
     * has function
     *
     * @param string $id
     *
     * @throws ContainerException
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        try {
            return !empty($id) && array_key_exists($id, $this->container_storage);
        } catch (\Throwable $th) {
            throw new ContainerException($th->getMessage(), 500);
        }
    }
}
