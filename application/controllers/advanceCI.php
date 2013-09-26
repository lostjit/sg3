<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	require_once('main.php');

class advanceCI extends Main {


	public function __construct(){
	
		
		parent::__construct();
	
	}

	public function index()
	{
		$this->load->view('index_adv');
	}
	
	
	public function signin()
	{
		$this->load->view('signin');
	}
	
	public function register()
	{
		$this->load->view('register');
	}
	
	
	public function process_register()
	{	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First name', 'alpha|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'alpha|required');
		$this->form_validation->set_rules('password', 'Password', 'min_length[6]|required|matches[conf_pw]');		
		$this->form_validation->set_rules('conf_pw', 'Password', 'min_length[6]|required');	
		
		$data = array();
		
		if ($_POST['action'] == 'addnewuser')
		{
			$usethis = 'newuserview';
		}
		else 
		{	
			$usethis = 'register';
		}
		
		if($this->form_validation->run() === FALSE)
		{
			$data['message'] = validation_errors();
			$this->load->view($usethis, $data);
		}
		else
		{
			$this->load->model('Mvcadv_user_model');
			$this->load->library('encrypt');
			$anyuser = $this->Mvcadv_user_model->get_user($_POST);	
			
			if (count($anyuser) > 0)
			{
				$data['message'] =  "Sorry, that email is already registered!";
				$this->load->view($usethis, $data);
			}
			else
			{			
				
				$anyusers  = $this->Mvcadv_user_model->get_all();
				
				$user_level = ($anyusers->num_rows > 0) ? 0 : 9;	
				
		
				$user_details = array('email'=> $_POST['email'], 'first_name'=> $_POST['first_name'], 'last_name'=> $_POST['last_name'], 'password'=> $this->encrypt->encode($_POST['password']), 'user_level' => $user_level, 'created_at' => date('Y-m-d H:i:s'));				
				
				$this->Mvcadv_user_model->register_user($user_details);
				
			
				
				
				
				if ($_POST['action'] == 'addnewuser')
				{
					$data['message'] = 'You have successfully added a new user!';
					$this->load->view('newuserview', $data);
				}
				else
				{				
					$data['message'] = 'You have successfully registered!';
					$this->load->view('signin', $data);
				}
			}
		}		
	}	
	
	public function loguserin()
	{
	
		$this->load->model('Mvcadv_user_model');
		$this->load->library('encrypt');
		$data['message'] = 'login unsuccessful!  Please try again';
			
		$anyuser = $this->Mvcadv_user_model->get_user($_POST);	
		if (count($anyuser) > 0)
		{
			$password = $this->encrypt->decode($anyuser->password);
			if ( $password == $_POST['password'])
			{
				$user= array();
				$user['first_name'] = $anyuser->first_name;
				$user['last_name'] = $anyuser->last_name;
				$user['email'] = $anyuser->email;
				$user['user_level'] = $anyuser->user_level;
				$user['password'] = $anyuser->password;
				$user['description'] = $anyuser->description;
				$user['id'] = $anyuser->id;
				
				
				
				$this->session->set_userdata('user_session', $user);
				$user_session = $this->session->userdata['user_session'];

				// var_dump($this->session);
				// die();
				//if you var dump here, the data is stored find.  then when it redirects to dashboard controller, data not there anymore.
			
			
				if ($anyuser->user_level == 0)			
					redirect('dashboard/index');
				else
					redirect('dashboard/admin');
			}
			else
				$this->load->view('signin', $data);
		}
		else 
		{	
			$this->load->view('signin', $data);
		}
	}
}

?>