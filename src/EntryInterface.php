<?php

declare(strict_types=1);

namespace Zheltikov\SimpleContainer;

use Psr\Container\ContainerInterface;

interface EntryInterface
{
    public function get(ContainerInterface $container): mixed;
}
