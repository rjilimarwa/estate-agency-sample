<?php

namespace AppBundle\Controller\BackOffice;

use AppBundle\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Property controller.
 *
 */
class PropertyController extends Controller
{
    /**
     * Lists all property entities.
     *
     */
    public function indexAction(Request $request)
    {
        //appel doctrine
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('AppBundle:Property')->findBy(array(),array('id'=>'desc'));
        $paginator = $this->get('knp_paginator');
        $properties = $paginator->paginate($query, $request->query->getInt('page', 1), 10);
        return $this->render('administration/property/index.html.twig', array(
            'properties' => $properties,
        ));
    }

    /**
     * Creates a new property entity.
     *
     */
    public function newAction(Request $request)
    {
        $property = new Property();
        $form = $this->createForm('AppBundle\Form\PropertyType', $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();

            return $this->redirectToRoute('property_show', array('id' => $property->getId()));
        }

        return $this->render('administration/property/new.html.twig', array(
            'property' => $property,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a property entity.
     *
     */
    public function showAction(Property $property)
    {
        $deleteForm = $this->createDeleteForm($property);

        return $this->render('administration/property/show.html.twig', array(
            'property' => $property,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing property entity.
     *
     */
    public function editAction(Request $request, Property $property)
    {
        $deleteForm = $this->createDeleteForm($property);
        $editForm = $this->createForm('AppBundle\Form\PropertyType', $property);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('property_index');
        }

        return $this->render('administration/property/edit.html.twig', array(
            'property' => $property,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a property entity.
     *
     */
    public function deleteAction(Request $request, Property $property)
    {
        if ($property) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($property);
            $em->flush();
            $this->addFlash('success', 'Le bien a été supprimé');
        }

        return $this->redirectToRoute('property_index');
    }

    /**
     * Creates a form to delete a property entity.
     *
     * @param Property $property The property entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Property $property)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('property_delete', array('id' => $property->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function forSaleAction(Request $request)
    {
        //appel doctrine
        $em = $this->getDoctrine()->getManager();

        // appel service paginatorBundle
        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('AppBundle:Property')->findBy(array('activate' => true, 'operation' => 'Vente'), array('id' => 'desc'));

        $properties = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 10)/*page number*/,
            1/*limit per page*/
        );

        return $this->render('administration/property/index.html.twig', array(
            'properties' => $properties,
        ));
    }

    /**
     * Properties for rent
     */
    public function forRentAction(Request $request)
    {
        //appel doctrine
        $em = $this->getDoctrine()->getManager();
        // requete
        $query = $em->getRepository('AppBundle:Property')->findBy(array('activate' => true, 'operation' => 'Location'), array('id' => 'desc'));

        // appel service paginatorBundle
        $paginator = $this->get('knp_paginator');
        $properties = $paginator->paginate($query, $request->query->getInt('page', 1), 1);

        return $this->render('administration/property/index.html.twig', array(
            'properties' => $properties,
        ));
    }
    public function formSearchAction(Request $request)
    {
        $property = new Property();
        $form = $this->createForm('AppBundle\Form\PropertySearchType', $property);
        $form->handleRequest($request);

        return $this->render('administration/property/form_search.html.twig', array(
            'form_search' => $form->createView(),
        ));
    }
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // recuperer tous les paramétres de l'url
        $data = $request->query->all(); // alors $data contient tous les parametres de l'url

        $query = $em->getRepository('AppBundle:Property')->search($data);

        // appel service paginatorBundle
        $paginator = $this->get('knp_paginator');
        $properties = $paginator->paginate($query, $request->query->getInt('page', 1), 10);

        return $this->render('administration/property/index.html.twig', array(
            'properties' => $properties,
        ));
    }
}
