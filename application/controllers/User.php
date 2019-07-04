<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('users_model');
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
		$this->load->library('recaptcha');

        //get all users
        $this->data['users'] = $this->users_model->getAllUsers();
	}

	public function index(){
		$this->load->view('reg_form', $this->data);
	}

	public function register(){
	 	$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|is_unique[tbl_users.user_email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[7]|max_length[30]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
		$captcha_answer = $this->input->post('g-recaptcha-response');
		$response = $this->recaptcha->verifyResponse($captcha_answer);

        if ($this->form_validation->run() == FALSE) { 
         	$this->session->set_flashdata('register','Error, please make sure that the email has not been registered yet, the password is more than 6 words long, and both passwords match');
         	$this->load->view('reg_form', $this->data);
		}else if (!$response['success']){
			$this->session->set_flashdata('reg_dang','Inccorect captcha');
         	$this->load->view('reg_form', $this->data);
		}
		else{
			//get user inputs
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$password = md5($this->input->post('password'));

			//generate simple random code
			$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$code = substr(str_shuffle($set), 0, 12);

			//insert user to users table and get id
			$user['user_name'] = $name;
			$user['user_email'] = $email;
			$user['user_password'] = $password;
			$user['code'] = $code;
			$user['active'] = false;
			$id = $this->users_model->insert($user);

			//set up email
			$config = array(
		  		'protocol' => 'smtp',
		  		'smtp_host' => 'ssl://smtp.googlemail.com',
		  		'smtp_port' => 465,
		  		'smtp_user' => 'tugasdaffa769@gmail.com', // change it to yours
		  		'smtp_pass' => 'XNymphaea13X', // change it to yours
		  		'mailtype' => 'html',
		  		'charset' => 'iso-8859-1',
		  		'wordwrap' => TRUE
			);

			$message = 	"
						<html>
						<head>
							<title>Verification Code</title>
						</head>
						<body>
							<h2>Thank you for Registering.</h2>
							<p>Please click the link below to activate your account.</p>
							<h4><a href='".base_url()."user/activate/".$this->users_model->base64_url_encode($code.''.$email)."'>Activate My Account</a></h4>
						</body>
						</html>
						";
	 		
		    $this->load->library('email', $config);
		    $this->email->set_newline("\r\n");
		    $this->email->from($config['smtp_user'], 'Tokobuah');
		    $this->email->to($email);
		    $this->email->subject('Signup Verification Email');
		    $this->email->message($message);

		    //sending email
		    if($this->email->send()){
		    	$this->session->set_flashdata('reg_succ','Activation code sent to email');
		    }
		    else{
		    	$this->session->set_flashdata('reg_dang', $this->email->print_debugger());
	 
		    }

        	redirect('user');
		}

	}

	public function activate(){
		$id =  $this->uri->segment(3);
		$data = $this->users_model->base64_url_decode($id);
		//fetch user details
		$user = $this->users_model->activate($data);
		//if code matches
		if($user == 'berhasil'){

			$this->session->set_flashdata('log_succ', 'Account activated successfully');
		}
		else{
			$this->session->set_flashdata('log_dang', 'Cannot activate account. Code didnt match');
		}
		redirect('login');
	}
}