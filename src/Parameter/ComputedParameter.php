<?php

declare(strict_types=1);

namespace Zheltikov\SimpleContainer\Parameter;

use Closure;
use Psr\Container\ContainerInterface;
use Zheltikov\SimpleContainer\ParameterInterface;

class ComputedParameter implements ParameterInterface
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
