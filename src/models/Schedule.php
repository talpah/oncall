<?php

namespace Models;

class Schedule extends BaseModel {

    protected $source = 'schedule';
    protected $fields = array('date', 'actor_id');
    private $actors;

    public function findByRange($startDate, $endDate) {
        $monday = $this->getMondayFor($startDate);
        $friday = $this->getFridayFor($endDate);
        $hasMonday = $this->findBy('date', $monday->format("Y-m-d"));
        $hasFriday = $this->findBy('date', $friday->format("Y-m-d"));
        if (!$hasMonday || !$hasFriday) {
            return false;
        }
        $sourceSize = $this->getSourceSize();
        $chunkSize = 50;
        $offset = 0;
        $rangeData=array();
        while(($offset+=$chunkSize)<=$sourceSize) {
            $data = $this->loadDataByOffset($offset-$chunkSize, $offset);
            $data =  array_values(array_filter($data, function($record) use ($monday, $friday) {
                return $record['date']>=$monday->format("Y-m-d")&&$record['date']<=$friday->format("Y-m-d");
            }));
            $rangeData = array_merge($rangeData, $data);
        }
        return $rangeData;
    }

    public function getFor($startDate, $endDate){
        $startDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);
        $data = $this->findByRange($startDate, $endDate);
        if ($data) {
            return $data;
        }
        $lastSchedule = $this->findLast(5);
        $lastDate = new \Datetime($lastSchedule[0]['date']);

        /* Find the Monday of the week containing $startDate */
        $genStartDate = $this->getMondayFor($startDate);

        /* Find the Friday of the week containing $endDate */
        $genEndDate = $this->getFridayFor($endDate);

        /* Compute diff from last recorded schedule to our start date */
        $days = $genStartDate->diff($lastDate)->days;
        $weeks = ($days/7)+1;

        /* Compute diff from start date to end date */
        $nextDays = $genEndDate->diff($genStartDate)->days;
        $nextWeeks = $nextDays/7;

        /* Generate each week */
        $this->actors = new Actor();
        $actor = new ActorOrder();
        $actor->setCursor($lastSchedule[0]['actor_id']-1,'actor_id');
        $loopStartDate = clone($lastDate);
        $loopStartDate->modify('+ 1 week');
        while ($weeks-->1) {
            $this->generateWeek($loopStartDate, $actor);
        }
        $loopStartDate = clone($endDate);
        while ($nextWeeks-->0) {
            $data []= $this->generateWeek($loopStartDate, $actor);
        }
        return $data;
    }

    public function generateWeek(\DateTime $mondayDate, $actor) {
        $weekData = array();
        for ($dayNo = 1; $dayNo<6; $dayNo++) {
            $actor_id = $actor->next('actor_id');
            $mondayDate->modify('+1 day');
            $weekData []= $data = array('date'=>$mondayDate->format("Y-m-d"), 'actor_id'=>$actor_id);
            $this->insert($data);
        }
        $mondayDate->modify('+2 days');
        return $weekData;
    }

    public function getMondayFor($startDate) {
        $startDOW = $startDate->format("N");
        if ($startDOW>1 && $startDOW<6) {
            $genStartDate = $startDate->modify('last Monday');
        } elseif ($startDOW>5) {
            $genStartDate = $startDate->modify('next Monday');
        } else {
            $genStartDate = $startDate;
        }
        return $genStartDate;
    }

    public function getFridayFor($endDate){
        $endDOW = $endDate->format("N");
        if ($endDOW<5) {
            $genEndDate = $endDate->modify('Friday');
        } else {
            $genEndDate = $endDate->modify('last Friday');
        }
        return $genEndDate;
    }

}