<?php

namespace App\Exceptions;

use App\Builder\RespostaBuilder;
use App\Providers\SerializeProvider;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{

    /**
     * @var SerializeProvider
     */
    public $serializeProvider;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Handler constructor.
     * @param SerializeProvider $serializeProvider
     */
    public function __construct(SerializeProvider $serializeProvider)
    {
        $this->serializeProvider = $serializeProvider;
    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $resposta = RespostaBuilder::getBuilder();

        switch ($e) {
            case ($e instanceof ValidationException):
                $status = Response::HTTP_BAD_REQUEST;
                $resposta->criarErro($e)
                    ->mensagens($e->validator->getMessageBag()->toArray());
                break;
            case ($e instanceof ServiceException):
                $status = $e->getCode();
                $resposta->criarErro($e)
                    ->criarMensagem($e);
                break;
            default:
                $status = $e->getCode();
                $resposta->criarErro($e)
                    ->mensagem("Ocorreu um erro no servidor");
                break;
        }
        return response()->json($this->serializeProvider->serialize($resposta->build()), $status);
    }
}
