<?php

namespace App\Repository;

use App\Entity\UserEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class UserEventRepository
 */
class UserEventRepository extends ServiceEntityRepository
{
    /**
     * UserEventRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserEvent::class);
    }
}
