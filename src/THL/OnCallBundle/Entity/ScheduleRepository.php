<?php

namespace THL\OnCallBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ScheduleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScheduleRepository extends EntityRepository {


    public function getJsonScheduleFor($startDate, $endDate) {
        return '[
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
]';
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @param int $mask Binary mask expected (0000000) 7 bits, start on Monday from right to left
     */
    public function generateSchedule(\DateTime $start, \DateTime $end, $mask){

    }
}