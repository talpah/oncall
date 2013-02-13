<?php

namespace THL\OnCallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller {
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction() {
        /**
         * @var \THL\OnCallBundle\Entity\ScheduleRepository $repo
         */
        $repo=$this->getDoctrine()->getRepository('THLOnCallBundle:Schedule');
        $repo->generateSchedule(new \DateTime(), new \DateTime('next week'), 4);
        return array('name'=>'$name');
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
