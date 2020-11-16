<?php

declare(strict_types=1);

namespace App\Model\Exception\Runtime\User;

final class EmailTakenException extends \App\Model\Exception\RuntimeException
{
    public function __construct(string $email)
    {
        parent::__construct(\sprintf('Email: %s is already taken.', $email));
    }
}
