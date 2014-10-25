<?php

class MY_Controller extends CI_Controller
{

    public $data = array();
    public $parser;
    
    public function __construct () {
        parent::__construct();     
        if ($this->session->userdata('loggedin') == 1) {
            $this->email = $this->session->userdata('email');
            $this->userid = $this->session->userdata('userid');
            $this->data['email'] = $this->email;
            $this->data['userid'] = $this->userid;
            $this->dateFormat = date("Y-m-d H:i:s");
        }
    }

    /**
     * Set subview and load layout
     * @param string $subview, $title
     */
    public function load_view ($subview, $title) {
        if ($this->session->userdata('loggedin') != 1) {
            redirect('/');
        }
        $this->data['content']  = $subview;
        $this->data['title']    = $title;
        $this->load->view('global/layouts/main', $this->data);
    }

    public function lobby_view ($subview, $title) {
        
        if ($this->session->userdata('loggedin') == 1) {
            redirect('users/chatboard');
        }        
        $this->data['title']    = $title;
        $this->data['content']  = $subview;
        $this->load->view('global/layouts/lobby', $this->data);
    }

}