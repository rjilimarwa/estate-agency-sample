<?php

namespace AppBundle\Controller\FrontOffice;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrontOfficeDefaultController extends Controller
{
    public function indexAction()
    {
        //appel doctrine
        $em = $this->getDoctrine()->getManager();

        //$entities = $em->getRepository('AppBundle:Property')->findBy(array('activate' => true), array('id' => 'desc'), 9, 0);

        $entities = $em->getRepository('AppBundle:Property')->latestProperties();

        return $this->render('frontOffice/default/index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formSearchAction(Request $request)
    {
        $property = new Property();
        $form = $this->createForm('AppBundle\Form\PropertySearchType', $property);
        $form->handleRequest($request);

        return $this->render('frontOffice/property/form_search_index.html.twig', array(
            'form_search' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Request $request)
    {
        $entity = new Contact();
        $form = $this->createForm('AppBundle\Form\ContactType', $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            $message = (new \Swift_Message('Hello Email'))
                ->setFrom($this->getParameter('mailer_user'))
                ->setTo($this->getParameter('mailer_user'))
                ->setReplyTo($form->get('email')->getData())
                ->setBody(
                    'ok'
                );

            $this->get('mailer')->send($message);

            $this->addFlash('notice', 'Votre messgae est envoyé avec succées');

            return $this->redirectToRoute('app_fronOffice_contact');
        }

        return $this->render('frontOffice/default/contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function aboutAction()
    {
        return $this->render('frontOffice/default/about.html.twig');
    }

}
