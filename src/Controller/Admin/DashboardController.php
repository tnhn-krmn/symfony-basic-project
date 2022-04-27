<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Category;
use App\Entity\Ticket;



class DashboardController extends AbstractController
{


    protected $doctrine;

    public function __construct(PersistenceManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    #[Route('/admin/category-new', name: 'category_new')]
    public function categoryAdd(Request $request): Response
    {
        $category = new Category();

        $form = $this->createFormBuilder($category)
            ->add('name', TextType::class)
            ->add('Save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $category = $form->getData();
            $em->persist($category);
            $em->flush();


            return  $this->redirect('/admin/dashboard');
        }

        return $this->render('admin/dashboard/category-add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/ticket-list', name: 'ticket_list')]
    public function ticketList(Request $request): Response
    {
        $ticketsRep = $this->doctrine->getRepository(Ticket::class);
        $tickets = $ticketsRep->findAll();

        return $this->render('admin/dashboard/list-ticket.html.twig', [
            'tickets' => $tickets,
        ]);
    }
}
