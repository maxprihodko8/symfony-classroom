<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Forms\ClassroomType;
use App\Repository\ClassroomRepository;
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
     * @param ClassroomRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * Get the list of the classrooms.
     */
    public function index(ClassroomRepository $repository): Response
    {
        $classrooms = $repository->findAll();

        return $this->json($classrooms);
    }

    /**
     * @Route("/classrooms/{id}", name="show", methods={"GET"})
     *
     * @param $id integer Classroom identifier
     * @param ClassroomRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * Get the specific classroom by the identifier.
     */
    public function show($id, ClassroomRepository $repository): Response
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

        return $this->json($form->getErrors(true), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/classrooms/{id}", name="update", methods={"PUT", "PATCH"})
     *
     * @param $id
     * @param Request $request
     * @param ClassroomRepository $repository
     * @param EntityManagerInterface $entityManager
     * @return Response
     *
     * Update the classroom action by the identifier.
     */
    public function update($id, Request $request, ClassroomRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $classroom = $this->findModel($id, $repository);

        $form = $this->createForm(ClassroomType::class, $classroom);

        $data = json_decode($request->getContent(), true);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->json($classroom);
        }

        return $this->json($form->getErrors(true), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/classrooms/{id}", methods={"DELETE"}, name="delete")
     *
     * @param $id
     * @param ClassroomRepository $repository
     * @param EntityManagerInterface $entityManager
     * @return Response
     *
     * Deletes the Classroom model by the identifier.
     */
    public function delete($id, ClassroomRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $classroom = $this->findModel($id, $repository);

        $entityManager->remove($classroom);
        $entityManager->flush();

        return $this->json([], JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/classrooms/{id}/state/active", methods={"PUT", "PATCH"}, name="set_state_active")
     *
     * @param $id
     * @param ClassroomRepository $repository
     * @param EntityManagerInterface $entityManager
     * @return Response
     *
     * This method set the state of the classroom to active or otherwise throw exception
     */
    public function setActive($id, ClassroomRepository $repository, EntityManagerInterface $entityManager): Response
    {
        return $this->setModelActiveState($id, true, $repository, $entityManager);
    }

    /**
     *
     * @Route("/classrooms/{id}/state/inactive", methods={"PUT", "PATCH"}, name="set_state_not_active")
     *
     * @param $id
     * @param ClassroomRepository $repository
     * @param EntityManagerInterface $entityManager
     * @return Response
     *
     * This method set the state of the classroom to inactive or otherwise throw exception
     */
    public function setNotActive($id, ClassroomRepository $repository, EntityManagerInterface $entityManager): Response
    {
        return $this->setModelActiveState($id, false, $repository, $entityManager);
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

    protected function setModelActiveState(int $id, bool $active, ServiceEntityRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $classroom = $this->findModel($id, $repository);

        if ($active === $classroom->isActive()) {
            return $this->json([
                'error' => 'State is already active or inactive',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $classroom->setActive(false);

        $entityManager->flush();

        return $this->json([]);
    }
}