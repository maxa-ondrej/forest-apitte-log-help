<?php

declare(strict_types=1);

namespace App\Model\Database\Entity\Attributes;

trait TId
{
    /**
     * @ORM\Column(type="integer", nullable=FALSE)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    public ?int $id;

    public function __clone()
    {
        $this->id = null;
    }
}
