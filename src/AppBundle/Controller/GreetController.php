<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Service\GreetService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GreetController extends Controller
{
    /**
     * @var GreetService
     */
    private $greetService;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        GreetService $greetService,
        EntityManagerInterface $entityManager
    )
    {
        $this->greetService = $greetService;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/greet", name="greet")
     */
    public function index(Request $request)
    {
        $name = $this->greetService->getNameFromRequest($request);

        /** @var Person $person */
        $person = $this->entityManager->getRepository(Person::class)->findOneBy(['name' => $name]);

        return $this->render('greet/index.html.twig', [
            'person' => $person,
        ]);
    }
}
