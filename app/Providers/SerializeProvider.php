<?php

namespace App\Providers;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializeProvider
{

    const SERIALIZE_JSON = 'json';


    /**
     * Serializa objeto em array
     * @param $data
     * @param string $type
     * @return mixed
     */
    public function serialize($data, $type = 'json')
    {
        return self::serializer($data, $type);
    }


    /**
     * Retorna objeto serializado em formato de array
     * @param object $data
     * @param string $type
     * @return mixed
     */
    public static function serializer($data, $type = 'json')
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        return json_decode($serializer->serialize($data, $type));
    }
}
