<?php

namespace App\Controller;

use App\Entity\Morceau;
use App\Form\MorceauType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/morceau")
 */
class MorceauController extends AbstractController
{
    /**
     * @Route("/", name="morceau_index", methods={"GET"})
     */
    public function index(): Response
    {
        $morceaus = $this->getDoctrine()
            ->getRepository(Morceau::class)
            ->findAll();

        return $this->render('morceau/index.html.twig', [
            'morceaus' => $morceaus,
        ]);
    }

    /**
     * @Route("/new", name="morceau_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $morceau = new Morceau();
        $form = $this->createForm(MorceauType::class, $morceau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($morceau);
            $entityManager->flush();

            return $this->redirectToRoute('morceau_index');
        }

        return $this->render('morceau/new.html.twig', [
            'morceau' => $morceau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="morceau_show", methods={"GET"})
     */
    public function show(Morceau $morceau): Response
    {
        return $this->render('morceau/show.html.twig', [
            'morceau' => $morceau,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="morceau_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Morceau $morceau): Response
    {
        $form = $this->createForm(MorceauType::class, $morceau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('morceau_index');
        }

        return $this->render('morceau/edit.html.twig', [
            'morceau' => $morceau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="morceau_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Morceau $morceau): Response
    {
        if ($this->isCsrfTokenValid('delete'.$morceau->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($morceau);
            $entityManager->flush();
        }

        return $this->redirectToRoute('morceau_index');
    }
}
