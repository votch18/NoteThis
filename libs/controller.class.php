<?php

class Controller {

    protected $data;
    protected $model;
    protected $params;
    protected $query;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function __construct($data = array()){
        $this->data = $data;
        $this->params = App::getRouter()->getParams();
        $this->query  = App::getRouter()->getQuery();
    }
}
