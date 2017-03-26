<?php

namespace TextBundle\Controller;

use TextBundle\Entity\Savoka;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Savoka controller.
 *
 * @Route("savoka")
 */
class SavokaController extends Controller
{
    /**
     * Lists all savoka entities.
     *
     * @Route("/", name="savoka_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $savokas = $em->getRepository('TextBundle:Savoka')->findAll();

        return $this->render('savoka/index.html.twig', array(
            'savokas' => $savokas,
        ));
    }

    /**
     * Creates a new savoka entity.
     *
     * @Route("/new", name="savoka_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $savoka = new Savoka();
        $form = $this->createForm('TextBundle\Form\SavokaType', $savoka);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($savoka);
            $em->flush($savoka);

            return $this->redirectToRoute('savoka_show', array('id' => $savoka->getId()));
        }

        return $this->render('savoka/new.html.twig', array(
            'savoka' => $savoka,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a savoka entity.
     *
     * @Route("/{id}", name="savoka_show")
     * @Method("GET")
     */
    public function showAction(Savoka $savoka)
    {
        $deleteForm = $this->createDeleteForm($savoka);

        return $this->render('savoka/show.html.twig', array(
            'savoka' => $savoka,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing savoka entity.
     *
     * @Route("/{id}/edit", name="savoka_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Savoka $savoka)
    {
        $deleteForm = $this->createDeleteForm($savoka);
        $editForm = $this->createForm('TextBundle\Form\SavokaType', $savoka);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('savoka_edit', array('id' => $savoka->getId()));
        }

        return $this->render('savoka/edit.html.twig', array(
            'savoka' => $savoka,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a savoka entity.
     *
     * @Route("/{id}", name="savoka_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Savoka $savoka)
    {
        $form = $this->createDeleteForm($savoka);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($savoka);
            $em->flush($savoka);
        }

        return $this->redirectToRoute('savoka_index');
    }

    /**
     * Creates a form to delete a savoka entity.
     *
     * @param Savoka $savoka The savoka entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Savoka $savoka)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('savoka_delete', array('id' => $savoka->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
