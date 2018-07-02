<?php

class AccountsController extends Controller
{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Account();
    }

    public function index()
    {

    }

    public function logout()
    {

        Session::destroy();
		setcookie("email", "", time()-86400, "/");
        Router::redirect('/');
    }
}
