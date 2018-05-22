<?php

class SignupController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Account();
    }
    public function index(){

        if ( $_POST ) {
            if ($this->model->signup($_POST)) {

                Router::redirect('/signup/success/');
            } else {
                Session::setFlash("<strong>Oh Snap!</strong> There was an error saving this record!");
            }
        }

    }

    public function success(){
        $this->data = null;
    }
}
