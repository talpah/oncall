<?php

namespace THL\OnCallBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use THL\OnCallBundle\Entity\Schedule;

/**
 * Schedule controller.
 *
 * @Route("/schedule")
 */
class ScheduleController extends Controller
{
    /**
     * Lists all Schedule entities.
     *
     * @Route("/", name="schedule")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('THLOnCallBundle:Schedule')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Schedule entity.
     *
     * @Route("/{id}", name="schedule_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('THLOnCallBundle:Schedule')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Schedule entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

}
