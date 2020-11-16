<?php

declare(strict_types=1);

namespace App\Model\Exception\Runtime\Database;

final class EntityNotFoundException extends \App\Model\Exception\RuntimeException
{
    public static function create(string $class, int $id): self
    {
        return new self(\sprintf('Entity of type %s for ID %d was not found', $class, $id));
    }
}
