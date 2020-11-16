<?php

declare(strict_types=1);

namespace App\Model\Database;

use Nettrine\ORM\EntityManagerDecorator;

class EntityManager extends EntityManagerDecorator
{
    use TRepositories;
}
