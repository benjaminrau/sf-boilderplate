<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Repository\PersonRepository;
use AppBundle\Service\GreetService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class BirthdayController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/birthday", name="birthday")
     */
    public function index(Request $request)
    {
        /** @var PersonRepository $repository */
        $repository = $this->entityManager->getRepository(Person::class);

        $persons = $repository->findThoseWithBirthdayToday();

        return $this->render('birthday/index.html.twig', [
            'persons' => $persons->filter(function (Person $person) {
                return strpos($person->name, 'Ben') !== false;
            }),
        ]);
    }
}
