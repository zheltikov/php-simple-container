<?php

declare(strict_types=1);

namespace Zheltikov\SimpleContainer\Parameter;

use Psr\Container\ContainerInterface;
use Zheltikov\SimpleContainer\ParameterInterface;

class RawParameter implements ParameterInterface
{
    public function __construct(
        protected mixed $value,
    ) {
    }

    public function get(ContainerInterface $container): mixed
    {
        return $this->value;
    }
}
