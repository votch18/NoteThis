<?php

class Note extends Model {

    public function getNotes(){

        $account_id = Session::get("id");
        $sql = "select * from t_notes where account_id='{$account_id}'";

        return $this->db->query($sql);
    }
	
	public function getOpenNotes(){

        $account_id = Session::get("id");
        $sql = "select * from t_notes where account_id='{$account_id}' and is_open = 1";

        return $this->db->query($sql);
    }

    public function getNotesById($note_id){
        $account_id = Session::get("id");
        $note_id = $this->db->escape($note_id);
        $sql = "select a.notes from t_notes a where a.account_id='{$account_id}' and a.note_id = '{$note_id}' limit 1";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }

    public function getNotesByNoteId($note_id){
        $account_id = Session::get("id");
        $note_id = $this->db->escape($note_id);
        $sql = "select * from t_notes a where a.account_id='{$account_id}' and a.note_id = '{$note_id}' limit 1";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }

	
	
    public function save($note_id = null, $notes = null){

        $note_id = !$note_id ? strtotime("now") : $this->db->escape($note_id);
        $account_id = Session::get("id");

        $notes = $this->db->escape($notes);

        if (!$note_id){

            $sql = "insert into t_notes
                set
                account_id = '{$account_id}',
                note_id = '{$note_id}',
                notes = '{$notes}',
                date = NOW(),
				mode = 1
            ";

        }else {
            $sql = "update t_notes
                set
                notes = '{$notes}',
                date = NOW()
                where note_id = '{$note_id}'
            ";

        }
        return $this->db->query($sql);
    }
	
	public function createNote(){
			$note_id = Util::generateRandomCode(5).strtotime("now");
			$account_id = Session::get("id");
			
			$sql = "insert into t_notes
					set
					account_id = '{$account_id}',
					note_id = '{$note_id}',
					date = NOW(),
					mode = 1,
					is_open = 1
				";
			return $this->db->query($sql);
	}
	
	public function closeNote($note_id){
		
		if (count(self::getOpenNotes()) > 1) {
			$note_id = $this->db->escape($note_id);
			$account_id = Session::get("id");
			
			$sql = "update t_notes
					set
					is_open =  2
					where note_id = '{$note_id}' and account_id = '{$account_id}'
				";

			return $this->db->query($sql);
		} else {
			return false;
		}
	}


    public function openNote($note_id){


            $note_id = $this->db->escape($note_id);
            $account_id = Session::get("id");

            $sql = "update t_notes
					set
					is_open =  1
					where note_id = '{$note_id}' and account_id = '{$account_id}'
				";

            return $this->db->query($sql);

    }
	
	
	
	public function deleteNote($note_id){

		if (count(self::getOpenNotes()) > 1) {
			$note_id = $this->db->escape($note_id);
			$account_id = Session::get("id");
			
			$sql = "delete from t_notes where note_id = '{$note_id}' and account_id = '{$account_id}'";

			return $this->db->query($sql);
		} else {
			return false;
		}
	}

    public function setMode($note_id, $mode){
        $note_id = $this->db->escape($note_id);
        $account_id = Session::get("id");
        $mode = (int)$this->db->escape($mode);


        $sql = "update t_notes
                set
                mode = {$mode}
                where note_id = '{$note_id}' and account_id = '{$account_id}'
            ";

        return $this->db->query($sql);
    }

    public function setLink($note_id, $link){
        $note_id = $this->db->escape($note_id);
        $account_id = Session::get("id");
        $link = $this->db->escape($link);


        $sql = "update t_notes
                set
                url = '{$link}'
                where note_id = '{$note_id}' and account_id = '{$account_id}'
            ";

        return $this->db->query($sql);
    }

    public function setPassword($note_id, $password ){
        $note_id = $this->db->escape($note_id);
        $account_id = Session::get("id");
        $password = md5($this->db->escape($password));


        $sql = "update t_notes
                set
                password = '{$password}'
                where note_id = '{$note_id}' and account_id = '{$account_id}'
            ";

        return $this->db->query($sql);
    }


    public function uploadImage($data)
    {

		$name = $_FILES['file']['name'];
		$temp_name = $_FILES['file']['tmp_name'];
		if (isset($name)) {
			if (!empty($name)) {
				$location = 'assets/img/';
				if (move_uploaded_file($temp_name, $location . $name)) {
				}
			}
		} else {
			return false;
		}

		return true;

    }
	
}