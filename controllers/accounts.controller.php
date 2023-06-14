<?php

class AccountsController extends Controller
{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Account();
    }

    public function logout()
    {

        Session::destroy();
		setcookie("email", "", time()-86400, "/");
        Router::redirect('/');
    }

    public function ajax_index()
    {
        if ($_GET) {
            Session::set('theme', $_GET['value']);
            $this->data = json_encode($this->model->setTheme($_GET['value']));
        }
    }

}