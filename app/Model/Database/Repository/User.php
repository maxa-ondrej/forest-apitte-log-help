<?php

declare(strict_types=1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\User as UserEntity;

/**
 * @method  UserEntity|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method  UserEntity|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method  UserEntity[] findAll()
 * @method  UserEntity[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<UserEntity>
 */
class User extends AbstractRepository
{
    public function findOneByEmail(string $email): ?UserEntity
    {
        dump($email);
        return $this->findOneBy(['email' => $email]);
    }

    public function findOneByUsername(string $username): ?UserEntity
    {
        dump($this->findOneBy(['username' => $username]));
        return $this->findOneBy(['username' => $username]);
    }

    public function findOneByPassword(string $password): ?UserEntity
    {
        return $this->findOneBy(['password' => $password]);
    }
}
