<?php

declare(strict_types=1);

namespace App\Model\Exception\Runtime\User;

final class UsernameTakenException extends \App\Model\Exception\RuntimeException
{
    public function __construct(string $username)
    {
        parent::__construct(\sprintf('Username: %s is already taken.', $username));
    }
}
