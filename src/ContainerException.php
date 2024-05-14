<?php

declare(strict_types=1);

namespace Zheltikov\SimpleContainer;

use Exception;
use Psr\Container\ContainerExceptionInterface;
use Throwable;

class ContainerException extends Exception implements ContainerExceptionInterface
{
    public function __construct(Throwable $throwable)
    {
        parent::__construct('Error while retrieving the entry', $throwable->getCode(), $throwable);
    }
}
