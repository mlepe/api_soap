<?php

namespace App\Controller;

use App\Entity\Membregroupe;
use App\Form\MembregroupeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/membregroupe")
 */
class MembregroupeController extends AbstractController
{
    /**
     * @Route("/", name="membregroupe_index", methods={"GET"})
     */
    public function index(): Response
    {
        $membregroupes = $this->getDoctrine()
            ->getRepository(Membregroupe::class)
            ->findAll();

        return $this->render('membregroupe/index.html.twig', [
            'membregroupes' => $membregroupes,
        ]);
    }

    /**
     * @Route("/new", name="membregroupe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $membregroupe = new Membregroupe();
        $form = $this->createForm(MembregroupeType::class, $membregroupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($membregroupe);
            $entityManager->flush();

            return $this->redirectToRoute('membregroupe_index');
        }

        return $this->render('membregroupe/new.html.twig', [
            'membregroupe' => $membregroupe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="membregroupe_show", methods={"GET"})
     */
    public function show(Membregroupe $membregroupe): Response
    {
        return $this->render('membregroupe/show.html.twig', [
            'membregroupe' => $membregroupe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="membregroupe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Membregroupe $membregroupe): Response
    {
        $form = $this->createForm(MembregroupeType::class, $membregroupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('membregroupe_index');
        }

        return $this->render('membregroupe/edit.html.twig', [
            'membregroupe' => $membregroupe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="membregroupe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Membregroupe $membregroupe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membregroupe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($membregroupe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('membregroupe_index');
    }
}
