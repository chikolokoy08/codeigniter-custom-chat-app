<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if($this->check_installation()) {
            $this->lobby_view('pages/login', 'Signin');
        }
    }

    public function signup () {
        $this->lobby_view('pages/signup', 'Create an Account');
    }    

    public function register() {

        $email = $this->input->post('email');


        if($this->user->checkEmail(array('email' => $email))) {
            $dataMessage = array('status' => 'error', 'message' => 'Email already exist. Try other email.');
            echo json_encode($dataMessage);
        } else {
            $dataRegister = array(
                'email' => $email, 
                'password' => $this->input->post('password'),
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname')               
            );

            if($this->user->registerNewUser($dataRegister)) {
                $dataMessage = array('status' => 'success', 'message' => 'Account created. You may now login.');
                echo json_encode($dataMessage);
            } else {
                $dataMessage = array('status' => 'error', 'message' => 'Can\'t create your account. Contact Jumpstart Creatives Support. <a href="http://jumpstartcreatives.com/contact-us">Click here</a>');
                echo json_encode($dataMessage);                
            }
        }

    }

    public function auth(){

        $dataLogin = array('email' => $this->input->post('email'), 'password' => $this->input->post('password'));
        $userData = $this->user->checkLogin($dataLogin);
        if (!$userData) {
            $dataMessage = array('status' => 'error', 'message' => 'Invalid Email / Password');
            echo json_encode($dataMessage);
        } else {
            session_start();
            $userdata = array(
                'userid' => $userData['id'],
                'email'    => $userData['email'],
                'loggedin'      => 1,
            );
            $this->session->set_userdata($userdata);
            $dataMessage = array('status' => 'success', 'message' => 'Please wait for redirection.', 'redirect' => '/users/chatboard');
            echo json_encode($dataMessage);            

        }

    }
    
    private function check_installation() {
        $this->load->dbutil();
        if (!$this->dbutil->database_exists('privatechat')) {
        } else {
            $this->checkUsersTable();
            $this->checkChatTable();            
        }
        return true;
    }
    
    private function checkUsersTable() {
        $query = $this->db->table_exists('pc_users');
        if(!$query) {
            $this->load->dbforge();
            $user_fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11, 
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                          ),
                'firstname' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 150,
                    'null' => TRUE,
                ),
                'lastname' => array(
                     'type' =>'VARCHAR',
                     'constraint' => 150,
                     'null' => TRUE,
                 ),
                'email' => array(
                     'type' =>'VARCHAR',
                     'constraint' => 150,
                     'null' => TRUE,
                 ),
                'username' => array(
                     'type' =>'VARCHAR',
                     'constraint' => 150,
                     'null' => FALSE,
                 ),
                'password' => array(
                     'type' =>'VARCHAR',
                     'constraint' => 150,
                     'null' => FALSE,
                 ),
                'profilepic' => array(
                     'type' =>'VARCHAR',
                     'constraint' => 150,
                     'null' => TRUE,
                 ),
                'salt' => array(
                     'type' =>'VARCHAR',
                     'constraint' => 150,
                     'null' => FALSE,
                 ),
                'status' => array(
                     'type' =>'BOOLEAN',
                     'default' => 0,
                 ),                 
                'date_active' => array(
                     'type' =>'DATETIME',
                     'null' => TRUE,
                 ),
                'last_login' => array(
                     'type' =>'TIMESTAMP',
                     'null' => TRUE,
                 )                
            );
            $this->dbforge->add_field($user_fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('pc_users', TRUE);     
        }
    }   
    
    private function checkChatTable() {
        $query = $this->db->table_exists('pc_messages');
        if(!$query) {
            $this->load->dbforge();
            $chat_fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11, 
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                          ),
                'from_sender' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 150,
                    'null' => FALSE,
                ),
                'to_sender' => array(
                     'type' =>'VARCHAR',
                     'constraint' => 150,
                     'null' => FALSE,
                 ),
                'message' => array(
                     'type' =>'TEXT',
                     'null' => FALSE,
                 ),                 
                'deleted' => array(
                     'type' =>'DATETIME',
                     'null' => TRUE,
                 ),
                 'received' => array(
                     'type' =>'TIMESTAMP',
                     'null' => FALSE,
                 )
            );
            $this->dbforge->add_field($chat_fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('pc_messages', TRUE);      
        }
    }       
}