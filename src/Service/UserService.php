<?php
namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;


class UserService
{
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function registerUser(User $u): bool
    {
        $isRegistered = false;

        if(strlen($u->getEmail())>8)
        {
            $this->userRepo->add($u);
            $isRegistered = true;
        }

        return $isRegistered;
    }
}