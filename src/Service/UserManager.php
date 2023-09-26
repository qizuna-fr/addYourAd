<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager
{
    private EntityManagerInterface $entityManager;

    public function create($email, $password, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($passwordHasher->hashPassword(
            $user,
            $password
        ));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}