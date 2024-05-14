<?php

declare(strict_types=1);

namespace Zheltikov\SimpleContainer\Service;

use Psr\Container\ContainerInterface;
use Zheltikov\SimpleContainer\ServiceInterface;

class ClassService implements ServiceInterface
{
    public function __construct(
        protected string $name,
        protected array $args = [],
    ) {
    }

    public function get(ContainerInterface $container): mixed
    {
        return new ($this->name)(...$this->args);
    }
}
