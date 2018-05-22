<?php

class Log extends Model
{

    public function getLogs(){
        $sql = "select * from t_logs";

        return $this->db->query($sql);
    }



    public function save($action){

        $action = $this->db->escape($action);
        $userid = Session::get('userid');

        $sql = "insert into t_logs
            set
            userid = '{$userid}',
            action = '{$action}',
            date = NOW()
        ";

        return $this->db->query($sql);
    }
}
