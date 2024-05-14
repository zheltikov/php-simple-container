<?php

declare(strict_types=1);

namespace Zheltikov\SimpleContainer;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends Exception implements NotFoundExceptionInterface
{
    public function __construct(string $id)
    {
        parent::__construct(
            sprintf(
                'No entry was found for %s',
                var_export($id, true),
            )
        );
    }
}
