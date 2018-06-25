<?php

namespace App\Providers;

use App\Entity\Users;
use App\Exceptions\ServiceException;
use App\Repository\UsersRepository;
use Firebase\JWT\JWT;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use LaravelDoctrine\ORM\Facades\EntityManager;

class UsersProvider
{

    /**
     * @var UsersRepository
     */
    private $usersRepository;

    /**
     * UsersProvider constructor.
     */
    public function __construct()
    {
        $this->usersRepository = EntityManager::getRepository(Users::class);
    }

    /**
     * @param $email
     * @return Users
     */
    public function recuperarUsuarioEmail($email) : ?Users
    {
        $users = current($this->usersRepository->findBy(array('email' => $email)));
        if ($users) {
            return $users;
        }
        return null;
    }

    public function login(string $email, string $password)
    {
        $user = $this->recuperarUsuarioEmail($email);
        if (!$user) {
            throw new ServiceException('Email não encontrado', Response::HTTP_BAD_REQUEST);

//            return response()->json([
//                'error' => 'Email não encontrado'
//            ], Response::HTTP_BAD_REQUEST);
        }
        // Verify the password and generate the token
        if (Hash::check($password, $user->getPassword())) {
            return response()->json([
                'token' => $this->jwt($user)
            ], Response::HTTP_OK);
        }
        // Bad Request response
        return response()->json([
            'error' => 'Email ou senha inválidos'
        ], Response::HTTP_FORBIDDEN);
    }

    /**
     * Create a new token.
     * @param Users $user
     * @return string
     */
    protected function jwt(Users $user)
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->getId(), // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function listarUsuarios()
    {
        return $this->usersRepository->findAll();
    }
}
