<?php

declare(strict_types=1);

namespace App\Domain\Backend\Facade;

use App\Domain\Backend\Request\LoginUserReqDto;
use App\Model\Database\Entity\User;
use App\Model\Database\EntityManager;
use App\Model\Exception\Runtime\User\EmailTakenException;
use App\Model\Exception\Runtime\User\UsernameTakenException;
use App\Model\Security\Passwords;

class Users
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function create(array $dto): User
    {
        if ($this->em->getUserRepository()->findOneByUsername($dto['username'])) {
            throw new UsernameTakenException($dto['username']);
        }
        if ($this->em->getUserRepository()->findOneByEmail($dto['email'])) {
            throw new EmailTakenException($dto['email']);
        }
        dump('OK');
        $user = new User(
            $dto['username'],
            $dto['email'],
            Passwords::create()->hash($dto['username'] . $dto['password']),
        );

        $this->em->persist($user);
        $this->em->flush($user);

        return $user;
    }

    public function findOne(array $dto): User
    {
        return $this->em->getUserRepository()->findOneByPassword(
            Passwords::create()->hash($dto['username'] . $dto['password']),
        );
    }
}
