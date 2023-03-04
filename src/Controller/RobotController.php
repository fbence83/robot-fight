<?php

namespace App\Controller;

use App\Entity\Robot;
use App\Form\RobotType;
use App\Repository\RobotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RobotController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

//    #[Route('/robot/new', name: 'robot_new')]
//    public function new(Request $request): Response
//    {
//        $robot = new Robot();
//        $robot->setCreatedAt(new \DateTime());
//        $form = $this->createForm(RobotType::class, $robot);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->entityManager->persist($robot);
//            $this->entityManager->flush();
//
//            return $this->redirectToRoute('app_homepage');
//        }
//
//        return $this->render('robot/new.html.twig', [
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @throws \Exception
     */
    #[Route('/robot/fight/', name: 'robot_fight', methods: ['POST'])]
    #[Route('/api/robot/fight/', name: 'robot_fight_api', methods: ['POST'])]
    public function fight(Request $request,): Response{

        try {
            $robotId1 = $request->query->get('robotId1');
            $robotId2 = $request->query->get('robotId2');

            $robot1 = $this->entityManager->getRepository(Robot::class)->find($robotId1);
            $robot2 = $this->entityManager->getRepository(Robot::class)->find($robotId2);


            if ($robot1->getPower() > $robot2->getPower()) {
                $winner = $robot1;
            } else if ($robot2->getPower() > $robot1->getPower()) {
                $winner = $robot2;
            } else {

                if ($robot1->getCreatedAt() > $robot2->getCreatedAt()) {
                    $winner = $robot1;
                } else {
                    $winner = $robot2;
                }
            }

            return new JsonResponse([
                "id" => $winner->getId(),
                "name" => $winner->getName(),
                "type" => $winner->getType(),
                "power" => $winner->getPower(),
                "created_at" => $winner->getCreatedAt(),
                "updated_at" => $winner->getUpdatedAt(),
                "deleted_at" => $winner->getDeletedAt(),
                "is_deleted" => $winner->isDeleted()
            ]);

        }catch (\Exception $e){
            throw $e;
        }

    }

    #[Route('/robot', name: 'robot_new', methods: ['GET', 'POST'])]
    #[Route('/robot/{id}', name: 'robot_edit', methods: ['GET', 'POST'])]
    public function robot(Request $request, Robot $robot = null): Response
    {

        // If no robot is provided, create a new one
        if ($robot === null) {
            $robot = new Robot();
        }

        $editMode = false;
        if($robot->getId() !== null){
            $editMode = true;
        }

        $form = $this->createForm(RobotType::class, $robot, ['edit_mode' => $editMode]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if($robot->getId() === null){
                $robot->setCreatedAt(new \DateTime());
                $this->entityManager->persist($robot);
            }
            $this->entityManager->flush();

            return $this->redirectToRoute('app_homepage');
        }


        return $this->render('robot/robot.html.twig', [
            'form' => $form->createView(),
            'editMode' => $robot->getId() !== null
        ]);
    }

    #[Route('/robot/{id}', name: 'robot_delete', methods: ['DELETE'])]
    public function delete(Request $request, Robot $robot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$robot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->entityManager;
            $robot->setIsDeleted(true);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_homepage');
    }

    #[Route('/', name: 'app_homepage', methods: ['GET'])]
    public function homepage(RobotRepository $robotRepository): Response
    {
        //$robots = $robotRepository->findAll();

        $robots = $this->entityManager->createQueryBuilder()
            ->select('r')
            ->from(Robot::class, 'r')
            ->where('r.isDeleted = false')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('robot/list.html.twig', [
            'robots' => $robots,
        ]);
    }

}
