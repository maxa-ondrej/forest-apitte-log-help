<?php

declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use App\Model\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\User")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 */
class User extends AbstractEntity
{
    use TId;
    use TCreatedAt;
    use TUpdatedAt;

    /** @ORM\Column(type="string", length=255, nullable=false, unique=true) */
    public string $username;

    /** @ORM\Column(type="string", length=255, nullable=false, unique=true) */
    public string $email;

    /** @ORM\Column(type="string", length=255, nullable=FALSE) */
    public string $password;

    /**
     * @var                         DateTime|NULL
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    public ?DateTime $lastLoggedAt;

    public function __construct(string $username, string $email, string $passwordHash)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $passwordHash;
    }

    public function changeLoggedAt(): void
    {
        $this->lastLoggedAt = new DateTime();
    }
}
