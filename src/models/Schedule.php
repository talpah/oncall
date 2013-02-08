<?php

namespace Models;

class Schedule extends BaseModel {

    protected $source = 'schedule';
    protected $fields = array('date', 'actor_id');
    private $actors;

    public function getFor($startDate, $endDate){
        $lastSchedule = $this->findLast(5);
        $startDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);
        $lastDate = new \Datetime($lastSchedule[0]['date']);

        /* Find the Monday of the week containing $startDate */
        $startDOW = $startDate->format("N");
        if ($startDOW>1 && $startDOW<6) {
            $genStartDate = $startDate->modify('last Monday');
        } elseif ($startDOW>5) {
            $genStartDate = $startDate->modify('next Monday');
        } else {
            $genStartDate = $startDate;
        }

        /* Compute diff */
        $interval = $genStartDate->diff($lastDate);
        $days = $interval->days;
        $weeks = ($days/7)+1;
        echo "<pre>";
        /* Generate each week */
        $this->actors = new Actor();
        $actor = new ActorOrder();
        $actor->setCursor($lastSchedule[0]['actor_id']-1,'actor_id');
        $loopStartDate = clone($lastDate);
        $loopStartDate->modify('+ 1 week');
        while ($weeks-->0) {
            $this->generateWeek($loopStartDate, $actor);
        }


        exit();
    }

    public function generateWeek(\DateTime $mondayDate, $actor) {
        for ($dayNo = 1; $dayNo<6; $dayNo++) {
            $actor_id = $actor->next('actor_id');
            $date = $mondayDate->modify('+1 day');
            echo $date->format("Y-m-d").": ".$this->actors->getXByY('name','id', $actor_id)."\n";
        }
        $mondayDate->modify('+2 days');

    }

}