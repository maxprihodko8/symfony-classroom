<?php

namespace App\Controller;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClassroomController
 * @package App\Controller
 *
 * The classroom CRUD controller, handles the classroom data load, update, change.
 */
class ClassroomController extends AbstractController
{
    /**
     * @Route("/classrooms", name="index")
     * @param ServiceEntityRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * Get the list of the classrooms
     */
    public function index(ServiceEntityRepository $repository)
    {
        $classrooms = $repository->findAll();

        return $this->json($classrooms);
    }

    /**
     * @Route("/classrooms/{id}", name="show")
     * @param $id integer Classroom identifier
     * @param ServiceEntityRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * Get the specific classroom by the identifier
     */
    public function show($id, ServiceEntityRepository $repository)
    {
        $classroom = $repository->find($id);

        if (!$classroom) {
            throw $this->createNotFoundException("The classroom was not found by the ID {$id}");
        }

        return $this->json($classroom);
    }
}