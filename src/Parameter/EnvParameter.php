<?php

declare(strict_types=1);

namespace Zheltikov\SimpleContainer\Parameter;

use Closure;
use Psr\Container\ContainerInterface;
use Zheltikov\SimpleContainer\ParameterInterface;

class EnvParameter implements ParameterInterface
{
    public function __construct(
        protected string $name,
        protected mixed $default = null,
        protected ?Closure $processor = null,
    ) {
    }

    public function get(ContainerInterface $container): mixed
    {
        if (array_key_exists($this->name, $_SERVER)) {
            return $this->processValue($this->parseValue($_SERVER[$this->name]));
        }

        if (array_key_exists($this->name, $_ENV)) {
            return $this->processValue($this->parseValue($_ENV[$this->name]));
        }

        if (($value = getenv($this->name)) !== false) {
            return $this->processValue($this->parseValue($value));
        }

        return $this->processValue($this->default);
    }

    protected function processValue(mixed $value): mixed
    {
        if ($this->processor !== null) {
            $value = ($this->processor)($value);
        }

        return $value;
    }

    protected function parseValue(mixed $value): mixed
    {
        if (!is_string($value)) {
            return $value;
        }

        return match (strtolower($value)) {
            'true', '(true)' => true,
            'false', '(false)' => false,
            'null', '(null)' => null,
            default => $value,
        };
    }
}
