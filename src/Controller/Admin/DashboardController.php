<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



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

    #[Route('/admin/ticket-new', name: 'ticket_new')]
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
}
