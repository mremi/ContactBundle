<?php

namespace Mremi\ContactBundle\Controller;

use Mremi\ContactBundle\ContactEvents;
use Mremi\ContactBundle\Event\ContactEvent;
use Mremi\ContactBundle\Event\FormEvent;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contact controller class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactController extends Controller
{
    /**
     * Index action in charge to render the form
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $dispatcher = $this->getEventDispatcher();
        $contact = $this->getContactManager()->create();

        $dispatcher->dispatch(ContactEvents::FORM_INITIALIZE, new ContactEvent($contact, $request));

        $form = $this->getFormFactory()->createForm($contact);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(ContactEvents::FORM_SUCCESS, $event);

                if (null === $response = $event->getResponse()) {
                    $response = new RedirectResponse($this->getRouter()->generate('mremi_contact_confirmation'));
                }

                return $response;
            }
        }

        return $this->render('MremiContactBundle:Contact:index.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Gets the event dispatcher
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private function getEventDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }

    /**
     * Gets the form factory
     *
     * @return \Mremi\ContactBundle\Form\Factory\FormFactory
     */
    private function getFormFactory()
    {
        return $this->container->get('mremi_contact.form_factory');
    }

    /**
     * Gets the contact manager
     *
     * @return \Mremi\ContactBundle\Model\ContactManagerInterface
     */
    private function getContactManager()
    {
        return $this->container->get('mremi_contact.contact_manager');
    }

    /**
     * Gets the router
     *
     * @return \Symfony\Component\Routing\RouterInterface
     */
    private function getRouter()
    {
        return $this->container->get('router');
    }
}
