<?php

namespace THL\OnCallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller {
    /**
     * @Route("/")
     * @Template("THLOnCallBundle:Default:schedule-grid.html.twig")
     */
    public function indexAction() {
        $start=new \DateTime('first day of this month');
        $end=new \DateTime('last day of this month');
        return array(
            'periodStart'=>$start->format("Y-m-d"),
            'periodEnd'  =>$end->format("Y-m-d")
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
        $start=new \DateTime('first day of this month');
        $end=new \DateTime('last day of this month');
        $response = $repo->generateSchedule($start, $end, 4);
        return new Response($response, 200, array('Content-Type'=>'application/json'));
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

    /**
     * @Route("/oncall/")
     */
    public function oncallAction() {
        return new RedirectResponse($this->generateUrl('thl_oncall_default_index'), 301);
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
