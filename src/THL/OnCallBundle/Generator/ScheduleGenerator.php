<?php
/**
 * Created by JetBrains PhpStorm.
 * User: share
 * Date: 03.03.2013
 * Time: 23:29
 * To change this template use File | Settings | File Templates.
 */

namespace THL\OnCallBundle\Generator;
use THL\OnCallBundle\Entity\Actor;

class ScheduleGenerator implements \Iterator
{

    /**
     * @var \DateInterval $oneDayInterval
     */
    private $oneDayInterval;
    /**
     * @var array $actors
     */
    private $actors;

    /**
     * @var Array $actorsByDate
     */
    private $actorsByDate;

    /**
     * @var int $actorCount
     */
    private $actorCount;
    /**
     * @var int $currentActor
     */
    private $currentActor;
    /**
     * @var \DateTime $startDate;
     */
    private $startDate;
    /**
     * @var \DateTime $endDate;
     */
    private $endDate;
    /**
     * @var \DateTime $currentDate;
     */
    private $currentDate;

    /**
     * @var int
     */
    private $direction = 1;

    /**
     * @param array $actors
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @throws \Exception
     */
    public function __construct(Array $actors, \DateTime $startDate, \DateTime $endDate)
    {
        $this->oneDayInterval = new \DateInterval('P1D');
        $this->actorCount = count($actors);
        if ($this->actorCount == 0) {
            throw new \Exception('No actors provided.');
        }
        $this->actors = $actors;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        if (!$this->validateActors()) {
            throw new \Exception('Provided actors do not have consecutive reference dates.');
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->actors[$this->currentActor];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->currentDate = $this->getNextWorkingDay($this->currentDate);
        if ($this->direction>0) {
            $this->currentActor = $this->currentActor == $this->actorCount - 1 ? 0 : $this->currentActor + 1;
        } else {
            $this->currentActor = $this->currentActor == 0 ?$this->actorCount - 1 : $this->currentActor -1;
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->currentDate->format('Y-m-d');
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->currentDate<=$this->endDate;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $actorDates = array_keys($this->getActorDates());
        $lastActorDate = new \DateTime($actorDates[$this->actorCount-1]);
        $dateDiff = $this->startDate->diff($lastActorDate);
        $dateDiff = $dateDiff->days * ($dateDiff->invert ? -1 : 1);
        if ($dateDiff >=0) {
            $this->direction = -1;
            $this->oneDayInterval->invert = 1;
        }
        $this->currentDate = $lastActorDate;
        $this->currentActor = $this->actorCount-1;
        while ($this->key()!=$this->startDate->format('Y-m-d')) {
            $this->next();
        }
        $this->direction=1;
        $this->oneDayInterval->invert=0;
    }

    /**
     * @param \DateTime $date
     * @return \DateTime
     */
    private function getNextWorkingDay($date)
    {
        $date->add($this->oneDayInterval);
        /* Skip weekends */
        while ($date->format('N') > 5) {
            $date->add($this->oneDayInterval);
        }
        return $date;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return bool
     */
    private function validateActors()
    {
        $previousDate = null;
        $actorDates = $this->getActorDates();
        $newList = array();
        foreach ($actorDates as $actorDate => $actor) {
            $actorDate = new \DateTime($actorDate);
            if (!$previousDate) {
                $previousDate = $actorDate->sub($this->oneDayInterval);
            }
            $diff = $actorDate->diff($previousDate)->format('a');
            if ($diff > 1) {
                return false;
            }
            $newList[]=$actor;
        }
        $this->actors = $newList;
        return true;
    }

    /**
     * @return array
     */
    private function getActorDates()
    {
        if ($this->actorsByDate) {
            return $this->actorsByDate;
        }
        $dates = array();
        foreach ($this->actors as $actor) {
            /**
             * @var Actor $actor
             */
            $dates[$actor->getReferenceDate()->format('Y-m-d')] = $actor;
        }
        ksort($dates);
        $this->actorsByDate = $dates;
        return $dates;
    }

}