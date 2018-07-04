<?php
/**
 * Created by PhpStorm.
 * User: cezarzaleski
 * Date: 03/07/2018
 * Time: 15:36
 */

namespace App\Builder;

class RespostaBuilder
{
    /**
     * @var Resposta
     */
    private $resposta;

    /**
     * RespostaBuilder constructor.
     */
    public function __construct()
    {
        $this->resposta = new Resposta();
    }

    public static function getBuilder(): RespostaBuilder
    {
        return new RespostaBuilder();
    }

    /**
     * @return Resposta
     */
    public function build(): Resposta
    {
        return $this->resposta;
    }

    public function resposta(Resposta $resposta): RespostaBuilder
    {
        $resposta->setResposta($resposta);
        return $this;
    }

    public function mensagem(string $mensagem): RespostaBuilder
    {
        $this->resposta->setMensagem($mensagem);
        return $this;
    }

    public function mensagens(array $mensagens): RespostaBuilder
    {
        $this->resposta->setMensagens($mensagens);
        return $this;
    }

    public function contemErro(bool $contemErro): RespostaBuilder
    {
        $this->resposta->setContemErro($contemErro);
        return $this;
    }

    public function excecao(string $excecao): RespostaBuilder
    {
        $this->resposta->setExcecao($excecao);
        return $this;
    }

    public function criarErro(\Exception $ex): RespostaBuilder
    {
        $this->contemErro(true);
        $this->excecao($ex->getMessage());
        return $this;
    }

    public function criarMensagem(\Exception $ex): RespostaBuilder
    {
        $this->contemErro(true);
        $this->mensagem($ex->getMessage());
        return $this;
    }
}
