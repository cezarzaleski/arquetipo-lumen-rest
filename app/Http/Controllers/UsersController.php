<?php

namespace App\Http\Controllers;

use App\Providers\UsersProvider;
use Validator;
use Illuminate\Http\Request;

/**
 * Class UsersController
 *
 * @package App\Http\Controllers
 *
 */
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
     * @SWG\Get(
     *     path="/users",
     *     tags={"users"},
     *     summary="Recuperar todos usuários",
     *     operationId="index",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid tag value",
     *     ),
     *      security={{
     *     "Bearer":{}
     *   }}
     * )
     */
    public function index()
    {
        $usuarios = $this->usersProvider->listarUsuarios();
        return response()->json($this->formatarResponse($usuarios));
    }
}
