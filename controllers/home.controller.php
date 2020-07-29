<?php

class HomeController extends Controller
{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Account();
    }

    public function index()
    {
        if ($_POST && isset ($_POST['email']) && isset ($_POST['password'])) {
            $user = $this->model->getByEmail($_POST['email']);
            $hash = md5($user['salt'] . $_POST['password']);

            if ($user && $hash == $user['password']) {
                Session::set('email', $user['email']);
                Session::set('access', "1");
                Session::set('login', "app");
                Session::set('theme', $user['theme']);

				setcookie('email', $user['email'], time() + (31556926), "/");
				
                $note = new Note();
                $notes = $note->getOpenNotes();
                if (count($notes) < 1) {
                    $note->createNote();
                }


                Router::redirect('/notes/');
            } else {
                Session::setFlash("Invalid username or password!");
            }
        }
    }

    public function ajax_index()
    {
        if ($_GET) {

            //check if email already exist if not login account
            Session::set('email', $_GET['email']);
            Session::set('access', "1");
            Session::set('login', "fb");

            $user = $this->model->getByEmail($_GET['email']);
            Session::set('theme', $user['theme']);

			setcookie('email', $_GET['email'], time() + (31556926), "/");
			
            $note = new Note();
            $notes = $note->getOpenNotes();
            if (count($notes) < 1) {
                $note->createNote();
            }


            $this->data = $this->data = $this->model->signup($_GET);


        }
    }

    public function page_not_found()
    {
        $this->data = null;
    }

}
