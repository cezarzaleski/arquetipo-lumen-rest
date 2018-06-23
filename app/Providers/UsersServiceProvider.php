<?php

namespace App\Providers;

use App\Entity\Users;
use App\Repository\UsersRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class UsersServiceProvider
{

    /**
     * @var UsersRepository
     */
    private $usersRepository;

    /**
     * UsersServiceProvider constructor.
     * @param UsersRepository $usersRepository
     */
    public function __construct($usersRepository)
    {
        $this->usersRepository = EntityManager::getRepository(Users::class);
    }

    public function login()
    {

    }
}
