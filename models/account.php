<?php

class Account extends Model
{


    public function getByEmail($email)
    {
        $email = $this->db->escape($email);
        $sql = "select a.*, ifnull((select value from t_account_settings x where x.account_id = a.email), 0) as theme  
                from t_accounts a where a.email='{$email}' limit 1";

        $result = $this->db->query($sql);
        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }

    public function getByUserId($id)
    {
        $id = $this->db->escape($id);
        $sql = "select * from t_accounts a where a.id='{$id}' limit 1";

        $result = $this->db->query($sql);
        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }


    public function signup($data)
    {

        $email = $this->db->escape($data['email']);
        $password = $this->db->escape($data['password']);
        $salt = self::generateRandomCode(5);
        $hash = md5($salt . $password);

        if (self::checkEmail($email)) return false;
        $sql = "insert into t_accounts
            set
            email = '{$email}',
            salt = '{$salt}',
            password = '{$hash}'
            ";

        return $this->db->query($sql);

    }

    public function checkEmail($email)
    {
        $email = $this->db->escape($email);
        $sql = "select * from t_accounts a where a.email='{$email}' limit 1";

        $result = $this->db->query($sql);
        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }


    public static function generateRandomCode($length = 50)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public function setTheme($value){

        $account_id = Session::get("email");

        if (self::checkTheme($account_id)){
            $sql = "update t_account_settings
				set
				value =  {$value}
				where account_id = '{$account_id}'
			";

            return $this->db->query($sql);
        }else{
            $sql = "insert into t_account_settings (account_id, settingsid, `value`) values
				('{$account_id}', 1, {$value})
			";

            return $this->db->query($sql);
        }
    }

    public function checkTheme($email)
    {
        $email = $this->db->escape($email);
        $sql = "select * from t_account_settings a where a.account_id='{$email}' limit 1";

        $result = $this->db->query($sql);
        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }
}
