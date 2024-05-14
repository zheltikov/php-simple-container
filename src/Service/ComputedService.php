<?php

declare(strict_types=1);

namespace Zheltikov\SimpleContainer\Service;

use Closure;
use Psr\Container\ContainerInterface;
use Zheltikov\SimpleContainer\ServiceInterface;

class ComputedService implements ServiceInterface
{
    public function __construct(
        protected Closure $fn,
    ) {
    }

    public function get(ContainerInterface $container): mixed
    {
        return ($this->fn)($container);
    }
}
