<?php

class Note extends Model
{

    public function getNotes()
    {

        $account_id = Session::get("email");
        $sql = "select * from t_notes where account_id='{$account_id}' and is_open <= 2";

        return $this->db->query($sql);
    }

    public function getOpenNotes()
    {

        $account_id = Session::get("email");
        $sql = "select * from t_notes where account_id='{$account_id}' and is_open = 1";

        return $this->db->query($sql);
    }

    public function getArchivedNotes()
    {

        $account_id = Session::get("email");
        $sql = "select * from t_notes where account_id='{$account_id}' and is_open = 3";

        return $this->db->query($sql);
    }

    public function getNotesById($note_id)
    {
        $account_id = Session::get("email");
        $note_id = $this->db->escape($note_id);
        $sql = "select a.notes from t_notes a where a.account_id='{$account_id}' and a.note_id = '{$note_id}' limit 1";

        $result = $this->db->query($sql);
        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }

    public function getNotesByNoteId($note_id)
    {
        $account_id = Session::get("email");
        $note_id = $this->db->escape($note_id);
        $sql = "select * from t_notes a where a.note_id = '{$note_id}' limit 1";

        $result = $this->db->query($sql);
        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }


    public function save($note_id = null, $notes = null, $title = null)
    {

        $note_id = !$note_id ? strtotime("now") : $this->db->escape($note_id);
        $account_id = Session::get("email");
        $title = Util::encrypt_decrypt("encrypt", $this->db->escape($title));
        $notes = Util::encrypt_decrypt("encrypt", $this->db->escape($notes));


        $sql = "update t_notes
			set
			title = '{$title}',
			notes = '{$notes}',
			date = NOW()
			where note_id = '{$note_id}'
		";


        return $this->db->query($sql);
    }

    public function createNote()
    {

        $note_id = Util::generateRandomCode(5) . strtotime("now");
        $account_id = Session::get("email");

        $sql = "insert into t_notes
				set
				account_id = '{$account_id}',
				note_id = '{$note_id}',
				date = NOW(),
				mode = 1,
				is_open = 1
			";
        $this->db->query($sql);

        return $note_id;
    }

    public function closeNote($note_id)
    {


        $note_id = $this->db->escape($note_id);
        $account_id = Session::get("email");

        $sql = "update t_notes
				set
				is_open =  2
				where note_id = '{$note_id}' and account_id = '{$account_id}'
			";

        return $this->db->query($sql);

    }


    public function openNote($note_id)
    {


        $note_id = $this->db->escape($note_id);
        $account_id = Session::get("email");

        $sql = "update t_notes
				set
				is_open =  1
				where note_id = '{$note_id}' and account_id = '{$account_id}'
			";

        return $this->db->query($sql);

    }

    public function archiveNote($note_id)
    {


        $note_id = $this->db->escape($note_id);
        $account_id = Session::get("email");

        $sql = "update t_notes
					set
					is_open =  3
					where note_id = '{$note_id}' and account_id = '{$account_id}'
				";

        return $this->db->query($sql);

    }


    public function deleteNote($note_id)
    {
        if (count(self::getOpenNotes()) > 1) {
            $note_id = $this->db->escape($note_id);
            $account_id = Session::get("email");

            $sql = "delete from t_notes where note_id = '{$note_id}' and account_id = '{$account_id}'";

            return $this->db->query($sql);
        } else {
            $note_id = $this->db->escape($note_id);
            $account_id = Session::get("email");

            $sql = "delete from t_notes where note_id = '{$note_id}' and account_id = '{$account_id}'";

            $this->db->query($sql);

            return self::createNote();

        }
    }

    public function setMode($note_id, $mode)
    {
        $note_id = $this->db->escape($note_id);
        $account_id = Session::get("email");
        $mode = (int)$this->db->escape($mode);


        $sql = "update t_notes
                set
                mode = {$mode}
                where note_id = '{$note_id}' and account_id = '{$account_id}'
            ";

        return $this->db->query($sql);
    }

    public function setLink($note_id, $link)
    {
        $note_id = $this->db->escape($note_id);
        $account_id = Session::get("email");
        $link = $this->db->escape($link);


        $sql = "update t_notes
                set
                url = '{$link}'
                where note_id = '{$note_id}' and account_id = '{$account_id}'
            ";

        return $this->db->query($sql);
    }

    public function setPassword($note_id, $password)
    {
        $note_id = $this->db->escape($note_id);
        $account_id = Session::get("email");
        $password = Util::encrypt_decrypt("encrypt", $this->db->escape($password));

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

    public function uploadImageTinyMCE($data)
    {

        header('Access-Control-Allow-Origin: *');

        $name = $_FILES['file']['name'];
        $temp_name = $_FILES['file']['tmp_name'];
        if (isset($name)) {
            if (!empty($name)) {
                $location = 'assets/img/';
                if (move_uploaded_file($temp_name, $location . $name)) {
                    return (array('location' => $location . $name));
                }
            }
        } else {
            return false;
        }

        //return (array('location' => $location.$name));
    }

}