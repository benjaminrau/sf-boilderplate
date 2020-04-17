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

        if (!empty($name)) {
            /** @var PersonRepository $repository */
            $repository = $this->entityManager->getRepository(Person::class);

            /** @var Person $person */
            $person = $repository->findOneBy(['name' => $name]);

            if (!$person) {
                throw new NotFoundHttpException(sprintf('Person with name %s not found', $name));
            }

            return $this->render('greet/index.html.twig', [
                'person' => $person,
            ]);
        }

        throw new BadRequestHttpException('name is required parameter');
    }
}
