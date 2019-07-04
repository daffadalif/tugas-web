<?php
class Login extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('login_model');
  }

  function index(){
    $this->load->view('login_view');
  }

  function auth(){
    $email    = $this->input->post('email',TRUE);
    $password = md5($this->input->post('password',TRUE));
    $validate = $this->login_model->validate($email,$password);
    $key = $this->login_model->active($email);
    if($validate->num_rows() > 0){
        $data  = $validate->row_array();
        $name  = $data['user_name'];
        $email = $data['user_email'];
        $sesdata = array(
            'username'  => $name,
            'email'     => $email,
            'logged_in' => TRUE
        );
        if ($key == 1) {
        $this->session->set_userdata($sesdata);
        redirect('admin');
        }else{
          $this->session->set_flashdata('login_succ','Account has not been activated');
          redirect('login');
        }
    }else{
        $this->session->set_flashdata('log_dang','Incorrect Username or Password');
        redirect('login');
    }
}

  function logout(){
      $this->session->sess_destroy();
      redirect('login');
  }
}