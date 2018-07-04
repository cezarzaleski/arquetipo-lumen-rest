<?php

namespace App\Http\Controllers;

use App\Builder\RespostaBuilder;
use App\Providers\SerializeProvider;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class AbstractController extends BaseController
{
    /**
     * Formatar resposta
     * @param object $data
     * @param string $type
     * @return mixed
     */
    protected function formatarResponse($data, $type = SerializeProvider::SERIALIZE_JSON)
    {
        return SerializeProvider::serializer(
            RespostaBuilder::getBuilder()->resposta($data)->build(),
            $type
        );
    }
}
