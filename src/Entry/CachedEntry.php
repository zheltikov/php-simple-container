<?php

declare(strict_types=1);

namespace Zheltikov\SimpleContainer\Entry;

use Psr\Container\ContainerInterface;
use Zheltikov\SimpleContainer\EntryInterface;

class CachedEntry implements EntryInterface
{
    protected bool $cached = false;
    protected mixed $cache = null;

    public function __construct(
        protected EntryInterface $inner,
    ) {
    }

    public function get(ContainerInterface $container): mixed
    {
        if ($this->cached === false) {
            $this->cache = $this->inner->get($container);
            $this->cached = true;
        }

        return $this->cache;
    }
}
