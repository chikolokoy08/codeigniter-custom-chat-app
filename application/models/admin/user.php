<?php

class User extends CI_Model {

    protected $table = 'pc_users';

    public function checkLogin ($data) {
        $dataLogin = array(
            'email' => $data['email'] 
        );
        $query = $this->db->get_where($this->table, $dataLogin);
        $rows = $query->first_row('array');

        if($rows) {
            $dbPassword = $rows['password'];
            $inputPassword = md5(base64_encode($data['password']).''.$rows['salt']);
            if($inputPassword === $dbPassword) {
                $this->loginUser($data['email']);
                return $rows;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function loginUser ($email){
        $updateLogin = array('status' => '1', 'last_login' => date("Y-m-d H:i:s"));
        $this->db->where('email', $email);
        $this->db->update($this->table, $updateLogin);
    }

    public function logoutUser ($email) {
        $updateLogin = array('status' => 0);
        $this->db->where(array('email' => $email));
        $this->db->update($this->table, $updateLogin);
        if($this->db->affected_rows() > 0) {
            return true;
        }   
        else {
            return false;
        }
    }     

    public function checkEmail ($data) {
        $query = $this->db->get_where($this->table, $data);
        return $query->first_row('array');
    }  

    public function getAllUsers () {
        return $this->db->get($this->table)->result();
    }  

    public function registerNewUser ($data) {
        $dateCreated = date('Y-m-d H:i:s');
        $salt = base64_encode(base64_encode($dateCreated));
        $password = md5(base64_encode($data['password']).''.$salt);
        $dataRegister = array(
            'email' => $data['email'], 
            'password' => $password,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'status' => 0,
            'salt' => $salt,
            'date_active' =>  $dateCreated             
        );
        $this->db->insert($this->table, $dataRegister);
        if($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function changePassword($data){
        $dataLogin = array(
            'email' => $this->email
        );
        $query = $this->db->get_where($this->table, $dataLogin);
        $rows = $query->first_row('array');
        $dbPassword = $rows['password'];
        $inputPassword = md5(base64_encode($data['oldpass']).''.$rows['salt']);
        if($inputPassword === $dbPassword) {
            if($data['newpass'] === $data['conpass']) {
                $newPass = md5(base64_encode($data['newpass']).''.$rows['salt']);
                $this->encryptNewPassword($rows['id'], $newPass);
                return true;
            } else {
                return 'not matched';
            }            
        } else {
          return 'invalid';  
        }        
    }

    private function encryptNewPassword($id, $newPass) {
        $updatePass = array('password' => $newPass);
        $this->db->where('id', $id);
        $this->db->update($this->table, $updatePass);        
    }

    public function getUserByEmail($email) {
        $dataLogin = array(
            'email' => $email
        );
        $query = $this->db->get_where($this->table, $dataLogin);
        return $query->first_row('array');
    }
        
}