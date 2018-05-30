<?php

namespace AppBundle\Controller\FrontOffice;

use AppBundle\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Property controller.
 *
 */
class PropertyFrontController extends Controller
{
    /**
     * Lists all property entities.
     *
     */
    public function indexAction()
    {
        //appel doctrine
        $em = $this->getDoctrine()->getManager();

        $properties = $em->getRepository('AppBundle:Property')->findBy(array('activate' => true), array('id' => 'desc'));

        return $this->render('frontOffice/property/index.html.twig', array(
            'properties' => $properties,
        ));
    }

    /**
     * Lists all property entities for sale.
     *
     */
    public function forSaleAction(Request $request)
    {
        //appel doctrine
        $em = $this->getDoctrine()->getManager();

        // appel service paginatorBundle
        $paginator = $this->get('knp_paginator');

        $query = $em->getRepository('AppBundle:Property')->findBy(array('activate' => true, 'operation' => 'Vente'), array('id' => 'desc'));

        $properties = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('frontOffice/property/index.html.twig', array(
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
        $properties = $paginator->paginate($query, $request->query->getInt('page', 1), 10);

        return $this->render('frontOffice/property/index.html.twig', array(
            'properties' => $properties,
        ));
    }


    public function showAction(Property $property)
    {
        $em = $this->getDoctrine()->getManager();

      //  $property = $em->getRepository('AppBundle:Property')->findOnebySlug($slug);

        $moreProperties = $em->getRepository('AppBundle:Property')->findBy(array('activate' => true), array('id' => 'desc'), 4, 0);

        return $this->render('frontOffice/property/show.html.twig', array(
            'property' => $property,
            'morePreperties' => $moreProperties
        ));
    }

    /*
     * Fonction pour retourner le formulaire de recherche
     */
    public function formSearchAction(Request $request)
    {
        $property = new Property();
        $form = $this->createForm('AppBundle\Form\PropertySearchType', $property);
        $form->handleRequest($request);

        return $this->render('frontOffice/property/form_search.html.twig', array(
            'form_search' => $form->createView(),
        ));
    }

    /*
     * fonction recherche biens
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // recuperer tous les paramétres de l'url
        $data = $request->query->all(); // alors $data contient tous les parametres de l'url

        $query = $em->getRepository('AppBundle:Property')->search($data);

        // appel service paginatorBundle
        $paginator = $this->get('knp_paginator');
        $properties = $paginator->paginate($query, $request->query->getInt('page', 1), 10);

        return $this->render('frontOffice/property/index.html.twig', array(
            'properties' => $properties,
        ));
    }
}
