<?php

class NotesController extends Controller
{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Note();
    }

    public function index()
    {

        if (Session::get("email") != "") {
			
			if ( count($this->model->getOpenNotes()) < 1 ) {
				$this->model->createNote();
			}
            $this->data = $this->model->getOpenNotes();
        } else {
            Router::redirect("/");
        }
    }

    public function view()
    {
        if ($this->params[0] != "") {
            //validate id
            $notes = $this->model->getNotesByNoteId($this->params[0]);
            if ($notes) {
                //check if public
                if ($notes['mode'] == "1") {
                    if ($notes['password'] != "" && Session::get($notes['note_id']) == "") {
                        Router::redirect("/notes/password/" . $notes['note_id']);
                    } else {

                        $this->data = $notes;

                    }
                } else {

                    $this->data = $notes;
                }
            }

        } else {
            Router::redirect("/");
        }

    }


    public function password()
    {

        if ($this->params[0] != "") {
            $this->data['id'] = $this->params[0];
        }

        if ($_POST) {
            $notes = $this->model->getNotesByNoteId($_POST['id']);
            $hash = Util::encrypt_decrypt("encrypt", $_POST['password']);
            if ($hash == $notes['password']) {
                Session::set($notes['note_id'], $notes['note_id']);

                Router::redirect('/notes/view/' . $notes['note_id']);
            } else {
                Session::setFlash("Invalid password!");
            }
        }
    }


    public function ajax_index()
    {
        if ($_GET) {

            if ($_GET['action'] == "save") {
				$result = $this->model->save($_GET['id'], $_GET['content'], $_GET['title']);
                $this->data = array('result' => $result);
            } else if ($_GET['action'] == "display") {
                $data = $this->model->getNotesById($_GET['id']);
                $decrypted_text = Util::encrypt_decrypt("decrypt", $data['notes']);
                $this->data =  array('content' => stripcslashes(trim($decrypted_text)));
            } else if ($_GET['action'] == "delete") {
                $this->data = $this->model->deleteNote($_GET['id']);
            } else if ($_GET['action'] == "close") {
                $this->data = $this->model->closeNote($_GET['id']);
            } else if ($_GET['action'] == "setMode") {
                $this->data = $this->model->setMode($_GET['id'], $_GET['mode']);
            } else if ($_GET['action'] == "setLink") {
                $this->data = $this->model->setLink($_GET['id'], $_GET['link']);
            } else if ($_GET['action'] == "setPass") {
                $this->data = $this->model->setPassword($_GET['id'], $_GET['password']);
            } else if ($_GET['action'] == "getData") {

                $res = $this->model->getNotesByNoteId($_GET['id']);
                $this->data = array('note_id' => $res['note_id'], 'title' => stripcslashes(Util::encrypt_decrypt("decrypt", $res['title'])), 'notes' => stripcslashes(Util::encrypt_decrypt("decrypt", $res['notes'])), 'is_open' => $res['is_open'], 'mode' => $res['mode'], 'password' => stripcslashes(Util::encrypt_decrypt("decrypt", $res['password'])), 'url' => $res['url']);

            } else if ($_GET['action'] == "getOpenNotes") {
                $notes = $this->model->getOpenNotes();
                $data = array();

                foreach ($notes as $res) {
                    array_push($data, array('note_id' => $res['note_id'], 'title' => stripcslashes(Util::encrypt_decrypt("decrypt", $res['title'])), 'notes' => stripcslashes(Util::encrypt_decrypt("decrypt", $res['notes']))));
                }

                $this->data = $data;
            } else if ($_GET['action'] == "getAllNotes") {
                $notes = $this->model->getNotes();
                $data = array();

                foreach ($notes as $res) {
                    array_push($data, array('note_id' => $res['note_id'], 'title' => stripcslashes(Util::encrypt_decrypt("decrypt", $res['title'])), 'notes' => stripcslashes(Util::encrypt_decrypt("decrypt", $res['notes'])), 'is_open' => $res['is_open']));
                }

                $this->data = $data;
            } else if ($_GET['action'] == "getArchiveNotes") {
                $notes = $this->model->getArchivedNotes();
                $data = array();

                foreach ($notes as $res) {
                    array_push($data, array(
					'note_id' => $res['note_id'], 
					'title' => stripcslashes(Util::encrypt_decrypt("decrypt", $res['title'])), 
					'notes' => stripcslashes(Util::encrypt_decrypt("decrypt", $res['notes'])), 
					'is_open' => $res['is_open'])
					);
                }

                $this->data = $data;
            } else if ($_GET['action'] == "setNoteOpen") {
                $this->data = $this->model->openNote($_GET['id']);
            } else if ($_GET['action'] == "archive") {
                $this->data = $this->model->archiveNote($_GET['id']);
            } else {
                $this->data = $this->model->createNote();
            }

        }
    }

    public function ajax_uploads()
    {
        if ($_POST) {
            $this->data = json_encode($this->model->uploadImage($_POST));
        }
    }




    public function ajax_upload()
    {
        if ($_POST) {
            //
            $this->data = $this->model->uploadImageTinyMCE($_POST);
        }
    }


}