<<<<<<< HEAD
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

    public function ajax_index()
    {
        if ($_GET) {
            Session::set('theme', $_GET['value']);
            $this->data = json_encode($this->model->setTheme($_GET['value']));
        }
    }

}
=======
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
>>>>>>> 4f74314149a233f04baf993f8456f72ae35eefce
