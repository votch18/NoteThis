<?php

class HomeController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Account();
    }
    public function index(){
        if ($_POST && isset ( $_POST['email']) && isset ($_POST['password'])){
            $user = $this->model->getByEmail($_POST['email']);
            $hash = md5($user['salt'].$_POST['password']);

            if ($user && $hash == $user['password']){
                Session::set('id', $user['id']);
                Session::set('email', $user['email']);
                Session::set('access', "1");

				$note = new Note();
				$note->createNote();
				
				
                Router::redirect('/');
            }else {
                Session::setFlash("Invalid username or password!");
            }
        }
    }

    public function dashboard(){

    }

    public function signup(){
        
        if ( $_POST ){
            if($this->model->signup($_POST)){
                Router::redirect('/home/success/');
            } else {
                Session::setFlash("<strong>Oh Snap!</strong> There was an error saving this record!");
            }
        }
    }

    public function new_note(){
        $this->data = null;
    }
	
	
	public function ajax_index(){
		if ( $_GET ) {
			
			//check if email already exist if not login account
			Session::set('email', $_GET['email']);
			Session::set('access', "1");
					
			$this->data	= $this->data = $this->model->signup($_GET);
			
			
		}
    }
	
}
