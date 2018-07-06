<?php

namespace App\Http\Controllers;

use App\Providers\UsersProvider;
use Illuminate\Http\JsonResponse;
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
     * @SWG\Response(
     *     response=200,
     *     description="OK",
     *     @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref="#/definitions/Resposta")
     *     ),
     * ),
     * security={{"Bearer":{}}}
     * )
     */
    public function index()
    {
        $usuarios = $this->usersProvider->listarUsuarios();
        return response()->json($this->formatarResponse($usuarios));
    }

    /**
     * @SWG\Post(
     *     path="/users",
     *     tags={"users"},
     *     summary="Inserir registro de usuário",
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *     @SWG\Schema(ref="#/definitions/Users")
     *     ),
     * @SWG\Response(
     *     response=201,
     *     description="Created",
     *     @SWG\Schema(ref="#/definitions/Resposta"),
     * ),
     * security={{"Bearer":{}}}
     * )
     */
    public function store()
    {
        $this->validar();
        $usuario = $this->usersProvider->salvar($this->request->toArray());
        return response()->json($this->formatarResponse($usuario));
    }

    /**
     * @SWG\Get(
     *     path="/users/{idUsuario}",
     *     tags={"users"},
     *     summary="Recuperar usuário pelo identificador",
     *     operationId="show",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="id do usuário",
     *         in="path",
     *         name="idUsuario",
     *         required=true,
     *         type="integer",
     *         format="int64"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     @SWG\Schema(ref="#/definitions/Resposta"),
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    public function show($idUsuario)
    {
        $usuarios = $this->usersProvider->recuperarUsuario($idUsuario);
        return response()->json($this->formatarResponse($usuarios));
    }

    /**
     * @SWG\Delete(
     *     path="/users/{idUsuario}",
     *     tags={"users"},
     *     summary="Excluir usuário pelo identificador",
     *     operationId="destroy",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="id do usuário",
     *         in="path",
     *         name="idUsuario",
     *         required=true,
     *         type="integer",
     *         format="int64"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     @SWG\Schema(ref="#/definitions/Resposta"),
     *     ),
     *     security={{"Bearer":{}}}
     * )
     */
    /**
     * @param $idUsuario
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($idUsuario): JsonResponse
    {
        $this->usersProvider->excluirUsuario($idUsuario);
        return response()->json($this->formatarResponse("Registro excluído com sucesso"));
    }


    /**
     * @SWG\Put(
     *     path="/users/{idUsuario}",
     *     tags={"users"},
     *     summary="Atualizar registro de usuário",
     *     @SWG\Parameter(
     *         description="id do usuário",
     *         in="path",
     *         name="idUsuario",
     *         required=true,
     *         type="integer",
     *         format="int64"
     *     ),
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *     @SWG\Schema(ref="#/definitions/Users")
     *     ),
     * @SWG\Response(
     *     response=200,
     *     description="OK",
     *     @SWG\Schema(ref="#/definitions/Resposta"),
     * ),
     * security={{"Bearer":{}}}
     * )
     */
    public function update($idUsuario)
    {
        $this->validar($idUsuario);
        $usuario = $this->usersProvider->salvar($this->request->toArray(), $idUsuario);
        return response()->json($this->formatarResponse($usuario));
    }

    /**
     * Validação dos dados de entrada
     * @param int|null $id
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validar(int $id = null)
    {
        $validacaoPadrao = [
            'name' => 'required',
            'email' => 'required|email|unique:App\Entity\Users,email',
            'password' => 'required'
        ];

        if (!empty($id)) {
            $validacaoPadrao = [
                'name' => 'required',
                'email' => 'required|email|unique:App\Entity\Users,email,'.$id,
                'password' => 'required'
            ];
        }
        $this->validate(
            $this->request,
            $validacaoPadrao
        );
    }
}
