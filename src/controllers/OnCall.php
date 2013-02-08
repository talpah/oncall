<?php

namespace Controllers;
use Models\Actor, Models\Schedule;

class OnCall extends BaseController {


    public function index() {

    }

    public function getActorsJson() {
        $this->view->setResponseType('json');
        $actors = new Actor();
        return json_encode($actors->findBy('name', 'an', false));
    }

    public function getAssignments($startDate, $endDate) {
        $this->view->setResponseType('json');
        $schedule = new Schedule();
        $actor = new Actor();
        $schedules = $schedule->getFor($startDate, $endDate);
        $list = array();
        foreach ($schedules as $scheduleItem) {
            $actorName=$actor->findBy('id',$scheduleItem['actor_id']);
            $actorName=$actorName[0]['name'];
            $list[]= array('date'=>$scheduleItem['date'], 'assignee'=>$actorName);
        }
        return json_encode($list);
    }

}