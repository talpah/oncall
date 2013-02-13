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
        $mdir = '/home/cosmin.iancu/www/oncall/app/cache';
        function delete($path) {
            $it = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path),
                \RecursiveIteratorIterator::CHILD_FIRST
            );
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
//        delete($mdir);
        return array('name'=>'$name');
    }

    /**
     * @Route("/json-get-assignments")
     * @Template()
     */
    public function jsonGetAssignmentsAction() {
        $response=new Response('[
    {"date":"2013-02-04", "assignee":"Cosmin I."},
    {"date":"2013-02-05", "assignee":"Robert S."},
    {"date":"2013-02-06", "assignee":"Alexandru V."},
    {"date":"2013-02-07", "assignee":"Stefan V."},
    {"date":"2013-02-08", "assignee":"Cosmin I."},

    {"date":"2013-02-11", "assignee":"Robert S."},
    {"date":"2013-02-12", "assignee":"Alexandru V."},
    {"date":"2013-02-13", "assignee":"Stefan V."},
    {"date":"2013-02-14", "assignee":"George V."},
    {"date":"2013-02-15", "assignee":"Cosmin I."},

    {"date":"2013-02-18", "assignee":"Robert S."},
    {"date":"2013-02-19", "assignee":"Alexandru V."},
    {"date":"2013-02-20", "assignee":"Stefan V."},
    {"date":"2013-02-21", "assignee":"George V."},
    {"date":"2013-02-22", "assignee":"Cosmin I."},

    {"date":"2013-02-25", "assignee":"Robert S."},
    {"date":"2013-02-26", "assignee":"Alexandru V."},
    {"date":"2013-02-27", "assignee":"Stefan V."},
    {"date":"2013-02-28", "assignee":"George V."},
    {"date":"2013-03-01", "assignee":"Cosmin I."}
]');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/run-test")
     * @Template("THLOnCallBundle:Default:run-test.html.twig")
     */
    public function runTestAction() {
        $result = 'a';
        return array(
            'result' => $result
        );
    }
}
