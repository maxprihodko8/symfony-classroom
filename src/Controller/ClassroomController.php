<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Forms\ClassroomType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/classrooms", name="index", methods={"GET"})
     *
     * @param ServiceEntityRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * Get the list of the classrooms.
     */
    public function index(ServiceEntityRepository $repository): Response
    {
        $classrooms = $repository->findAll();

        return $this->json($classrooms);
    }

    /**
     * @Route("/classrooms/{id}", name="show", methods={"GET"})
     *
     * @param $id integer Classroom identifier
     * @param ServiceEntityRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * Get the specific classroom by the identifier.
     */
    public function show($id, ServiceEntityRepository $repository): Response
    {
        $classroom = $this->findModel($id, $repository);

        return $this->json($classroom);
    }

    /**
     * @Route("/classrooms", name="create", methods={"POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     *
     * Create new classroom action.
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classroom = new Classroom();

        $form = $this->createForm(ClassroomType::class, $classroom);

        $data = json_decode($request->getContent(), true);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->json($classroom, JsonResponse::HTTP_CREATED);
        }

        return $this->json($form->getErrors(), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/classrooms/{id}", name="update", methods={"PUT", "PATCH"})
     *
     * @param $id
     * @param Request $request
     * @param ServiceEntityRepository $repository
     * @param EntityManagerInterface $entityManager
     * @return Response
     *
     * Update the classroom action by the identifier.
     */
    public function update($id, Request $request, ServiceEntityRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $classroom = $this->findModel($id, $repository);

        $form = $this->createForm(ClassroomType::class, $classroom);

        $data = json_decode($request->getContent(), true);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->json($classroom);
        }

        return $this->json($form->getErrors(), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/classrooms/{id}", methods={"DELETE"}, name="delete")
     *
     * @param $id
     * @param ServiceEntityRepository $repository
     * @param EntityManagerInterface $entityManager
     * @return Response
     *
     * Deletes the Classroom model by the identifier.
     */
    public function delete($id, ServiceEntityRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $classroom = $this->findModel($id, $repository);

        $entityManager->remove($classroom);
        $entityManager->flush();

        return $this->json([], JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param $id
     * @param ServiceEntityRepository $repository
     * @return Classroom
     *
     * Returns the Classroom model, otherwise throws the not found exception.
     */
    protected function findModel($id, ServiceEntityRepository $repository): Classroom
    {
        $classroom = $repository->find($id);

        if (!$classroom) {
            throw $this->createNotFoundException("The classroom was not found by the ID {$id}");
        }

        return $classroom;
    }
}