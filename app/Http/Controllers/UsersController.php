<?php

namespace App\Http\Controllers;

use App\Providers\UsersProvider;
use Validator;
use App\User;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class UsersController extends BaseController
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
     * Authenticate a user and return the token if the provided credentials are correct.
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(User $user)
    {
        $this->validate($this->request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        return $this->usersProvider->login(
            $this->request->input('email'),
            $this->request->input('password')
        );
    }
}
