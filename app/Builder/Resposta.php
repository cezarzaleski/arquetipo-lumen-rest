<?php

namespace App\Builder;

/**
 * Resposta
 *
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="Resposta")
 * )
 */
class Resposta
{

    /**
     * @var mixed
     * @SWG\Property(type="object")
     */
    private $resposta;

    /**
     * @SWG\Property()
     * @var string
     */
    private $mensagem;

    /**
     * @SWG\Property(
     *     type="array",
     *     @SWG\Items(
     *         type="string"
     *     ),
     * )
     * @var array
     */
    private $mensagens = array();

    /**
     * @var string
     * @SWG\Property()
     */
    private $excecao;

    /**
     * @SWG\Property(format="bool")
     * @var bool
     */
    private $contemErro;

    /**
     * @return string
     */
    public function getMensagem():? string
    {
        return $this->mensagem;
    }

    /**
     * @param string $mensagem
     * @return Resposta
     */
    public function setMensagem(string $mensagem): Resposta
    {
        $this->mensagem = $mensagem;
        return $this;
    }

    /**
     * @return string
     */
    public function getExcecao():? string
    {
        return $this->excecao;
    }

    /**
     * @param string $excecao
     * @return Resposta
     */
    public function setExcecao(string $excecao): Resposta
    {
        $this->excecao = $excecao;
        return $this;
    }

    /**
     * @return bool
     */
    public function isContemErro():? bool
    {
        return $this->contemErro;
    }

    /**
     * @param bool $contemErro
     * @return Resposta
     */
    public function setContemErro(bool $contemErro): Resposta
    {
        $this->contemErro = $contemErro;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResposta()
    {
        return $this->resposta;
    }

    /**
     * @param mixed $resposta
     * @return Resposta
     */
    public function setResposta($resposta)
    {
        $this->resposta = $resposta;
        return $this;
    }

    /**
     * @param array $mensagens
     * @return Resposta
     */
    public function setMensagens(array $mensagens): Resposta
    {
        $this->mensagens = $mensagens;
        return $this;
    }

    /**
     * @return array
     */
    public function getMensagens(): array
    {
        return $this->mensagens;
    }
}
