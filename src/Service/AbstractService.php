<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;

class AbstractService
{

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $entity
     * @param bool $flush
     * @throws OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function saveEntity($entity, $flush = true)
    {
        $this->entityManager->persist($entity);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    /**
     * @param $entity
     * @param bool $flush
     * @throws OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function removeEntity($entity, $flush = true)
    {
        $this->entityManager->remove($entity);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

}
