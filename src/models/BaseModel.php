<?php

namespace Models;

abstract class BaseModel {

    protected $source=null;
    protected $fields=null;

    protected $dataLoaded=false;

    private $sourcePath=null;
    private $dataSet=null;

    private $dataSize=0;
    private $iterableData=array();
    private $cursor=-1;


    public function __construct() {
        if (!$this->source || !$this->fields) {
            $message = get_class($this).': Invalid model specification.';
            throw new \Exception($message);
        }

        $this->sourcePath = ROOT.'/data/'.$this->source.'.json';

        if (!file_exists($this->sourcePath)) {
            $message = get_class($this).': Unable to find source: '.$this->sourcePath.'.';
            throw new \Exception($message);
        }
    }

    public function insert($data) {
        $file = file($this->sourcePath);
        $insertPos = count($file)-1;
        $data = "\t" . json_encode($data);
        $file[$insertPos-1].=',';
        $file[$insertPos] = $data;
        $file[]=']';
        file_put_contents($this->sourcePath, implode("\n", $file));
    }

    public function findAll() {
        $this->loadData();
        return $this->dataSet;
    }

    public function findLast($count) {
        $data = $this->loadDataByOffset($count*-1);
        return json_decode($data, true);
    }

    public function findBy($field, $value, $strict=true) {
        $this->loadData();
        return $strict ? $this->arrayFindStrict($this->dataSet, $field, $value) : $this->arrayFindLike($this->dataSet, $field, $value);
    }

    public function setCursor($position, $field) {
        $this->initIterable($field);
        $this->cursor = $position;
    }

    public function next($field) {
        $this->initIterable($field);
        $this->cursor = (++$this->cursor>$this->size-1)?0:$this->cursor;
        return $this->iterableData[$this->cursor];
    }

    public function get($field) {
        $this->initIterable($field);
        return $this->dataSet[$this->cursor][$field];
    }

    public function getXByY($x, $y, $yval) {
        $me = $this->findBy($y, $yval);
        return $me[0][$x];
    }

    protected function arrayFindStrict($array, $key, $value) {
        return array_values(array_filter($array, function($record) use ($key, $value) {
            return isset($record[$key])&&$record[$key]==$value;
        }));
    }

    protected function arrayFindLike($array, $key, $value) {
        return array_values(array_filter($array, function($record) use ($key, $value) {
            return isset($record[$key])&&strpos($record[$key], $value)!==false;
        }));
    }

    protected function loadData($forceReload=false) {
        if ($forceReload || !$this->dataLoaded) {
            $this->dataSet = json_decode(file_get_contents($this->sourcePath), true);
            $this->dataLoaded = true;
        }
    }

    protected function loadDataByOffset($start, $end=null) {
        if ($start<0 && is_null($end)) {
            $start = $this->getSourceSize()+$start+1;
        }
        $chunk = array();
        $linecount=0;
        $handle = fopen($this->sourcePath, "r");
        while(!feof($handle)){
          $line = fgets($handle, 4096);
          $linecount += trim($line)&&trim($line)!='['&&trim($line)!=']';
          if ($linecount>=$start && (is_null($end) || $linecount<=$end)) {
              $chunk []= $line;
          }
          if (!is_null($end) && $linecount>=$end) {
              break;
          }
        }
        fclose($handle);

        $chunkSize = count($chunk);
        $chunkFirstLine=trim($chunk[0]);
        $chunkLastLine=trim($chunk[$chunkSize-1]);
        if ($chunkFirstLine && $chunkFirstLine!='[') {
            array_unshift($chunk, '[');
        }
        if ($chunkLastLine && $chunkLastLine[strlen($chunkLastLine)-1]==',') {
            $chunk[count($chunk)-1] = substr($chunkLastLine,0,-1);
        }
        if ($chunkLastLine && $chunkLastLine!=']') {
            $chunk[]=']';
        }

        return implode("\n", $chunk);
    }

    private function getSourceSize() {
        $linecount = 0;
        $handle = fopen($this->sourcePath, "r");
        while(!feof($handle)){
            $line = fgets($handle, 4096);
            $linecount +=trim($line)&& trim($line)!='['&&trim($line)!=']';
        }

        fclose($handle);
        return $linecount;
    }

    private function initIterable($field) {
        if (!$this->iterableData){
            $data = $this->findAll();
            $this->iterableData = array_map(function($elem) use ($field) { return $elem[$field]; }, $data);
            $this->size = count($this->iterableData);
        }
    }

}