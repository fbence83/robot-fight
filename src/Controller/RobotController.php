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

/**
 * Robot vezérlő osztály.
 */
class RobotController extends AbstractController
{

    /** @var EntityManagerInterface EntityManager. */
    private $entityManager;

    /**
     *
     * Robot vezérlő osztály konstruktora.
     *
     * @param EntityManagerInterface $entityManager EntityManager.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     *
     * A robotok harcát megvalósító metódus. Paraméterül 2 robot azonosítót kap, és a nagyobb erejű robot adataival tér vissza. Döntetlen esetén az újabban létrehozottal.
     * Api hívás is implementálva van az /api/robot/fight végponton.
     *
     * @param Request $request Request objektum.
     * @return Response Response objektumot ad vissza.
     * @throws \Exception
     */
    #[Route('/robot/fight/', name: 'robot_fight', methods: ['POST'])]
    #[Route('/api/robot/fight/', name: 'robot_fight_api', methods: ['POST'])]
    public function fight(Request $request): Response{

        try {
            //kiszedem az urlből a 2 robot id-t
            $robotId1 = $request->query->get('robotId1');
            $robotId2 = $request->query->get('robotId2');

            //lekérem id-k alapján a robotokat
            $robot1 = $this->entityManager->getRepository(Robot::class)->find($robotId1);
            $robot2 = $this->entityManager->getRepository(Robot::class)->find($robotId2);


            //itt történik a csata
            //a nagyobb erejű robot lesz a nyertes
            //döntetlen estén az újabban létrehozott
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

    /**
     *
     * Egy robot adatainak menedzseléséhez szükséges formot állítja össze. Paramétertől függően felvétel vagy módosítás operáció történhet a lapon.
     * Ha nincs paraméterben átadva robot azonosító, akkor egy új robot létrehozása fog történni. Ellenkező esetben paraméter szerinti meglévő robot módosítása lehetséges.
     *
     * @param Request $request Request objektum.
     * @param Robot|null $robot Robot objektum. Nem kötelező, lehet null is.
     * @return Response Response objektumot ad vissza.
     */
    #[Route('/robot', name: 'robot_new', methods: ['GET', 'POST'])]
    #[Route('/robot/{id}', name: 'robot_edit', methods: ['GET', 'POST'])]
    public function robot(Request $request, Robot $robot = null): Response
    {

        //ha nincs robot átadva, példányosítunk egy újat
        if ($robot === null) {
            $robot = new Robot();
        }

        //ellenőrizzük hogy hozzáadás vagy módosítás fog-e történni
        //ha van a robotnak id-ja, akkor létezik, tehát módosítás, ellenkező esetben hozzáadás
        $editMode = false;
        if($robot->getId() !== null){
            $editMode = true;
        }

        //létrehozzuk a formot
        $form = $this->createForm(RobotType::class, $robot, ['edit_mode' => $editMode]);
        //kezeljük a form submitet
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //hozzáadás esetén beállítjuk a létrehozás dátumát
            if($robot->getId() === null){
                $robot->setCreatedAt(new \DateTime());
                $this->entityManager->persist($robot);
            }
            $this->entityManager->flush();

            //a lista nézetre irányítson át
            return $this->redirectToRoute('app_homepage');
        }


        //renderelje ki a robot lapot
        return $this->render('robot/robot.html.twig', [
            'form' => $form->createView(),
            'editMode' => $robot->getId() !== null
        ]);
    }

    /**
     *
     * Törli a paraméterben kapott id szerinti robotot. Soft delete történik, szóval az adatbázisból fizikailag nem kerül törlésre.
     *
     * @param Request $request Request objektum.
     * @param Robot $robot Robot objektum.
     * @return Response
     */
    #[Route('/robot/{id}', name: 'robot_delete', methods: ['DELETE'])]
    public function delete(Request $request, Robot $robot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$robot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->entityManager;
            $robot->setDeletedAt(new \DateTime());
            $robot->setIsDeleted(true);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_homepage');
    }

    /**
     *
     * Az applikáció kezdőlapja, ezen van a robotok listája.
     *
     * @param RobotRepository $robotRepository Robot repository objektum.
     * @return Response
     */
    #[Route('/', name: 'app_homepage', methods: ['GET'])]
    public function homepage(RobotRepository $robotRepository): Response
    {

        //a nem törölt robotokat listázzuk
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
