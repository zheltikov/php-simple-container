<?php

declare(strict_types=1);

namespace Zheltikov\SimpleContainer;

use Psr\Container\ContainerInterface;
use Throwable;

class Container implements ContainerInterface
{
    /**
     * @param array<string, EntryInterface> $entries
     */
    public function __construct(
        protected array $entries = [],
    ) {
    }

    public function get(string $id): mixed
    {
        if (!array_key_exists($id, $this->entries)) {
            throw new NotFoundException($id);
        }

        try {
            return $this->entries[$id]->get($this);
        } catch (Throwable $e) {
            throw new ContainerException($e);
        }
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->entries);
    }
}
