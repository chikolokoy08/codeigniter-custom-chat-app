<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/chat_model');
    }

    public function index() {
        redirect('users/chatboard');
    }

    public function chatboard() {
        $this->data['users'] = $this->user->getAllUsers();
        $this->load_view('pages/chatboard', 'Chatboard');
    }

    public function logout() {
        if($this->user->logoutUser($this->email)) {
            $this->session->sess_destroy();
            $this->db->cache_delete_all();
            redirect('/');            
        }
    }

    public function change_password() {
        $passArray = array(
            'oldpass' => $this->input->post('old-password'),
            'newpass' => $this->input->post('new-password'),
            'conpass' => $this->input->post('confirm-password')
        );
        $changedPass = $this->user->changePassword($passArray);
        if ($changedPass === 'invalid') {
            $dataMessage = array('status' => 'error', 'message' => 'Wrong Old Password');
        } else if ($changedPass === 'not matched') {
            $dataMessage = array('status' => 'error', 'message' => 'New and Confirm Password does not match');
        } else if ($changedPass === true){
            $dataMessage = array('status' => 'success', 'message' => 'Password Updated');
        }
        echo json_encode($dataMessage);
    }

    public function chat() {
        $id = $this->input->get('id');
        $getChat = $this->chat_model->getMessages($id);
        echo json_encode($getChat);
    }

    public function chat_new() {
        $id = $this->input->get('id');
        $timestamp = trim($this->input->get('timestamp'));
        $getChat = $this->chat_model->getNewMessages($id, $timestamp);
        echo json_encode($getChat);
    }   

    public function chat_count() {
        $id = $this->input->get('id');
        $timestamp = trim($this->input->get('timestamp'));
        $getChat = $this->chat_model->getChatCount($id, $timestamp);
        echo json_encode($getChat);        
    }

    public function chatsend() {
        $chatData = array(
            'from_sender' => $this->input->post('chat_to'),
            'message' => $this->input->post('message'),
            'received' => date('Y-m-d H:i:s'),
            'to_sender' => $this->userid,
        );
        $sendChat = $this->chat_model->insertChatData($chatData);
        echo json_encode($sendChat);
    } 

    public function profile($email=null) {
        if (!$email) {
            redirect('users/chatboard');
        } else {
            $this->data['emailValid'] = $this->user->getUserByEmail($email);
            $this->load_view('pages/profile', 'Profile of '.$email.'');            
        }

    }
    
}