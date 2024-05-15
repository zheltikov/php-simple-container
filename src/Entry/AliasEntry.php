<?php

declare(strict_types=1);

namespace Zheltikov\SimpleContainer\Entry;

use Psr\Container\ContainerInterface;
use Zheltikov\SimpleContainer\EntryInterface;

class AliasEntry implements EntryInterface
{
    public function __construct(
        protected string $alias,
    ) {
    }

    public function get(ContainerInterface $container): mixed
    {
        return $container->get($this->alias);
    }
}
