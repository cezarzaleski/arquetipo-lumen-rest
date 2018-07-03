<?php

namespace App\Http\Controllers;

use App\Providers\UsersProvider;
use Validator;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    /**
     * @SWG\Post(
     *     path="/auth/login",
     *     tags={"auth"},
     *     summary="Post to URL",
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="email",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="password",
     *                  type="string"
     *              )
     *          )
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Example extended response",
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="data",
     *              )
     *          )
     *     )
     * )
     */
    public function authenticate()
    {
        $this->validate(
            $this->request,
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
//            [
//                'email.required' => 'O campo email é obrigatório',
//                'email.email' => 'O campo email é inválido',
//                'password.required' => 'O campo senha é obrigatório',
//            ]
        );

        return $this->usersProvider->login(
            $this->request->input('email'),
            $this->request->input('password')
        );
    }
}
