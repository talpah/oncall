<?php

namespace Models;

abstract class BaseModel {

    protected $source=null;
    protected $fields=null;
    
    protected $dataLoaded=false;
    
    private $sourcePath=null;
    private $dataSet=null;
    
    
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
    
    public function findAll() {
        $this->loadData();
        return $this->dataSet;
    }
    
    
    protected function loadData() {
        if (!$this->dataLoaded) {
            $this->dataSet = json_decode(file_get_contents($this->sourcePath), true);
            $this->dataLoaded = true;
        }
    }
    
}