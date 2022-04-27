<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use App\Entity\Ticket;
use App\Entity\User;


class UserController extends AbstractController
{

    public function __construct(PersistenceManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/user/user-form', name: 'app_user_user')]
    public function index(): Response
    {

        $user = $this->getUser()->getid();
        $ticketsRep = $this->doctrine->getRepository(Ticket::class);
        $tickets = $ticketsRep->find($user);

        
        return $this->render('user/user/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }
}
