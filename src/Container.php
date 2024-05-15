<?php

declare(strict_types=1);

namespace Zheltikov\SimpleContainer;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Psr\Container\ContainerInterface;
use Throwable;
use Traversable;

class Container implements ContainerInterface, ArrayAccess, Countable, IteratorAggregate
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

    public function insert(string $id, EntryInterface $entry): static
    {
        $this->entries[$id] = $entry;
        return $this;
    }

    public function remove(string $id): static
    {
        unset($this->entries[$id]);
        return $this;
    }

    /**
     * @param array<string, EntryInterface> $entries
     */
    public function extendWith(array $entries): static
    {
        return new static(
            entries: array_merge($this->entries, $entries),
        );
    }

    /**
     * @return array<string, EntryInterface>
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @param array<string, EntryInterface> $entries
     */
    public function setEntries(array $entries): static
    {
        $this->entries = $entries;
        return $this;
    }

    // -------------------------------------------------------------------------

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->insert($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->remove($offset);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->entries);
    }

    public function count(): int
    {
        return count($this->entries);
    }
}
