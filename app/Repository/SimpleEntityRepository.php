<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Representação básica de um repositório de entidades.
 */
class SimpleEntityRepository extends EntityRepository
{
    public function save(array $data, $id = null)
    {
        if (!$data && !$id) {
            throw new \InvalidArgumentException('Não foi possível encontrar dados para persistir.');
        }

        $entityManager = $this->getEntityManager();
        $entityName = $this->getEntityName();
        $resolvedData = $this->resolveReferences($data);
        if ($id) {
            $entity = $entityManager->getReference($entityName, $id);
            $entity->fromArray($resolvedData);
        } else {
            $entity = new $entityName($resolvedData);
        }

        // Pré
        if ($id) {
            $this->preUpdate($entity);
        } else {
            $this->preInsert($entity);
        }

        $entityManager->persist($entity);
        // verificar esses dois métodos para realizar apenas para a entidade
        $entityManager->flush();
        $entityManager->clear();

        // Pos
        if ($id) {
            $this->postUpdate($entity);
        } else {
            $this->postInsert($entity);
        }

        return $entity;
    }

    /**
     * Resolve as referências no array de dados.
     *
     * @param array $data
     * @return array
     */
    protected function resolveReferences(array $data)
    {
        $resolvedData = array();

        foreach ($data as $key => $value) {
            $resolvedValue = $value;
            if ($value instanceof Reference) {
                switch ($value->getType()) {
                    case Reference::PARTIAL:
                        $resolvedValue = $this->getEntityManager()
                                              ->getPartialReference($value->getName(), $value->getId());
                        break;
                    case Reference::FULL:
                        $resolvedValue = $this->getEntityManager()
                                              ->getReference($value->getName(), $value->getId());
                        break;
                    default:
                        $resolvedValue = $value;
                        break;
                }
            }
            $resolvedData[$key] = $resolvedValue;
        }

        return $resolvedData;
    }

    // ---- INSERT -----------------------------------------------------------------------------------------------------

    /**
     * Efetua operação antes de executar o insert
     */
    protected function preInsert($entity)
    {
    }

    /**
     * Efetua operações depois de executar o insert
     */
    protected function postInsert($entity)
    {
    }

    // ---- UDPATE -----------------------------------------------------------------------------------------------------

    /**
     * Efetua operações antes de executar o update
     */
    protected function preUpdate($entity)
    {
    }

    /**
     * Efetua operações depois de executar o update
     */
    protected function postUpdate($entity)
    {
    }

    // ---- DELETE -----------------------------------------------------------------------------------------------------
    /**
     * {@inheritDoc}
     * @see \Commons\Pattern\Repository\Repository::delete()
     */
    public function delete($id)
    {
        $reference = $this->getEntityManager()->getReference($this->getEntityName(), $id);
        if ($reference) {
            $this->preDelete($reference);

            $this->getEntityManager()->remove($reference);
            // verificar o flush para realizar apenas para a entidade
            $this->getEntityManager()->flush();

            $this->postDelete($reference);
        }
    }

    /**
     * Efetua operações antes de executar o delete
     */
    protected function preDelete($reference)
    {
    }

    /**
     * Efetua operações depois de executar o delete
     */
    protected function postDelete($reference)
    {
    }

    /**
     * {@inheritDoc}
     * @see \Commons\Pattern\Paginator\PaginatorAware::createPaginator()
     */
    public function createPaginator()
    {
        return new EntityPaginator($this);
    }
}
