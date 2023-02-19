<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\PlatType;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlatController extends AbstractController
{
    /**
     * This controller display all plats
     *
     * @param PlatRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/plat', name: 'plat.index', methods: ['GET'])]
    public function index(
        PlatRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $plats = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('pages/plat/index.html.twig', [
            'plats' => $plats
        ]);
    }

    /**
     * This controller show a form which create an plat
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/plat/nouveau', 'plat.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
        ) : Response
    {
        $plat = new Plat();
        $form = $this->createForm(PlatType::class, $plat);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $plat = $form->getData();
            
            $manager->persist($plat);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre a été créer avec succes !'
            );

            return $this->redirectToRoute('plat.index');
       
        }

        return $this->render('pages/plat/newPlat.html.twig', [
            'form' => $form->createView()
        ]);
    }
#[Route('/plat/edition/{id}', 'plat.edit', methods: ['GET', 'POST'])]
    public function edit(PlatRepository $repository, int $id) :Response
    {
        $plat = $repository->findOneBy(["id" => $id]);
        $form = $this->createForm(PlatType::class, $plat);
        return $this->render('pages/plat/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
