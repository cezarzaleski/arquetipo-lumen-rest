<?php

namespace App\Http\Controllers;

use App\Providers\UsersProvider;
use Validator;
use Illuminate\Http\Request;

class UsersController extends AbstractController
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;


    /**
     * @var UsersProvider
     */
    private $usersProvider;

    /**
     * AuthController constructor.
     * @param Request $request
     * @param UsersProvider $usersProvider
     */
    public function __construct(Request $request, UsersProvider $usersProvider)
    {
        $this->request = $request;
        $this->usersProvider = $usersProvider;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $usuarios = $this->usersProvider->listarUsuarios();
        return $this->serialize($usuarios, $this::SERIALIZE_JSON);
    }
}
