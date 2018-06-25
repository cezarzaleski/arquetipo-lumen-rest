<?php

namespace App\Http\Controllers;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class AbstractController extends BaseController
{

    const SERIALIZE_JSON = 'json';

    protected function serialize($data, $type)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($data, $type);
    }
}
