<?php

declare(strict_types=1);

namespace App\Domain\Backend\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class LoginUserReqDto
{
    /** @Assert\NotBlank */
    public string $username;

    /** @Assert\NotBlank */
    public string $password;
}
