<?php

namespace App\Repository;

use App\Entity\Classroom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ClassroomRepository
 * @package App\Repository
 *
 * Repository for the classrooms. Handles the load of the data from the Classrooms
 */
class ClassroomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass = Classroom::class)
    {
        parent::__construct($registry, $entityClass);
    }
}