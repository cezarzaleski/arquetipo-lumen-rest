<?php

namespace App\Entity;

use Zend\Hydrator\ClassMethods;

abstract class AbstractEntity
{

    /**
     * Construtor padrão.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        if (!empty($options)) {
            $this->fromArray($options);
        }
    }

    /**
     * Assign entity properties using an array
     *
     * @param array $attributes assoc array of values to assign
     * @return null
     */
    public function fromArray(array $options)
    {
        $hydrator = new ClassMethods();
        $hydrator->hydrate($options, $this);
    }
}
