<?php

namespace THL\OnCallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller {
    /**
     * @Route("/")
     * @Template("THLOnCallBundle:Default:schedule-grid.html.twig")
     */
    public function indexAction() {
        /**
         * @var \THL\OnCallBundle\Entity\ScheduleRepository $repo
         */
        $repo=$this->getDoctrine()->getRepository('THLOnCallBundle:Schedule');
        $start = new \DateTime('first day of this month');
        $end = new \DateTime('last day of this month');
        $repo->generateSchedule($start, $end, 4);
        return array(
            'periodStart'=>$start->format("Y-m-d"),
            'periodEnd'=>$end->format("Y-m-d")
        );
    }

    /**
     * @Route("/week")
     * @Template("THLOnCallBundle:Default:schedule-grid.html.twig")
     */
    public function weekAction() {
        /**
         * @var \THL\OnCallBundle\Entity\ScheduleRepository $repo
         */
        $repo=$this->getDoctrine()->getRepository('THLOnCallBundle:Schedule');
        $start = new \DateTime('monday this week');
        $end = new \DateTime('friday this week');
        $repo->generateSchedule($start, $end, 4);
        return array(
            'periodStart'=>$start->format("Y-m-d"),
            'periodEnd'=>$end->format("Y-m-d")
        );
    }

    /**
     * @Route("/json-get-assignments")
     * @Template()
     */
    public function jsonGetAssignmentsAction() {
        /**
         * @var \THL\OnCallBundle\Entity\ScheduleRepository $repo
         */
        $repo=$this->getDoctrine()->getRepository('THLOnCallBundle:Schedule');
        $response=new Response($repo->getJsonScheduleFor('', ''));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/run-test")
     * @Template("THLOnCallBundle:Default:run-test.html.twig")
     */
    public function runTestAction() {
        $result='a';
        return array(
            'result'=>$result
        );
    }

    private function clearCache($path) {
        $it=new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        /**
         * @var \SplFileInfo $file
         */
        foreach ($it as $file) {
            if (in_array($file->getBasename(), array('.', '..'))) {
                continue;
            } elseif ($file->isDir()) {
                rmdir($file->getPathname());
            } elseif ($file->isFile() || $file->isLink()) {
                unlink($file->getPathname());
            }
        }
        rmdir($path);
    }
}
