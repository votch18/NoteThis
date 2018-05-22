<?php

class NotesController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Note();
    }
    public function index(){
        
    }

    public function view(){
        if ( $this->getParams() != "" ){
            //validate id
            $notes = $this->model->getNotesByNoteId($this->params[0]);
            if($notes){
                //check if public
                if($notes['mode'] == "2" ){
                    if($notes['password'] != "" && Session::get($notes['note_id']) == ""){
                        Router::redirect("/notes/password/".$notes['note_id']);
                    }else {
                        $this->data = $notes;
                    }
                }else {

                    if($notes['account_id'] == Session::get("id")){
                        $this->data = $notes;
                    }else {
                        Session::setFlash("This is a private note!");
                    }
                }
            }

        }else {
            Router::redirect("/");
        }
    }


    public function password(){

        $notes = $this->model->getNotesByNoteId($this->params[0]);

        if ($_POST ){
            $hash = md5($_POST['password']);

            if ($hash == $notes['password']){
                Session::set($notes['note_id'], $notes['note_id']);

                Router::redirect('/notes/view/'.$notes['note_id']);
            }else {
                Session::setFlash("Invalid password!");
            }
        }
    }

	
	public function ajax_index(){
		if ( $_GET ){
			
			if($_GET['action'] == "save"){
				$this->data = $this->model->save($_GET['id'], $_GET['content']);
			}else if($_GET['action'] == "display"){
				$this->data = $this->model->getNotesById($_GET['id']);
			}else if($_GET['action'] == "delete"){
				$this->data = $this->model->deleteNote($_GET['id']);
			}else if($_GET['action'] == "close") {
                $this->data = $this->model->closeNote($_GET['id']);
            }else if($_GET['action'] == "setMode"){
                    $this->data = $this->model->setMode($_GET['id'], $_GET['mode']);
            }else if($_GET['action'] == "setLink"){
                $this->data = $this->model->setLink($_GET['id'], $_GET['link']);
            }else if($_GET['action'] == "setPass"){
                $this->data = $this->model->setPassword($_GET['id'], $_GET['password']);
            }else if($_GET['action'] == "getData"){
                $this->data = $this->model->getNotesByNoteId($_GET['id']);
            }else if($_GET['action'] == "setNoteOpen"){
                $this->data = $this->model->openNote($_GET['id']);
			}else{
                $this->data = $this->model->createNote();
            }
			
		}
    }
	
	public function ajax_uploads(){
		if ( $_POST ){
            $this->data = json_encode($this->model->uploadImage($_POST));
        }
	}


}