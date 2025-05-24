<?php

namespace Onofre\TestMontink25\System\Exception;

use Psr\Container\NotFoundExceptionInterface;

use InvalidArgumentException;

class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface {}
