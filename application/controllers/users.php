<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require('main.php');

class Users extends Main {


	public function __construct(){
	
		
		parent::__construct();
	
	}

	public function index()
	{
	
		
	
		
	}
	
	
	public function newuser()
	{
		$this->load->view('newuserview');		
	}
	
	
	
	public function profile()
	{
		$this->load->view('profile');		
	}
	
	public function showprofile($userid)
	{
		$this->load->model('Mvcadv_user_model');
		$data = $this->Mvcadv_user_model->get_user_info($userid);
		$this->load->view('show', $data);		
	}
	
	public function edit()
	{
		$this->load->view('useredit');		
	}
	
	public function show()
	{
		$this->load->view('show');		
	}
	
	public function saveChanges()
	{
	
		$this->load->model('Mvcadv_user_model');
		
		$anyuser = $this->Mvcadv_user_model->get_user($_POST);

		
		if (count($anyuser) > 0)
		{		
		$userlevelnow = ($_POST['ddluserlvel'] == 'Admin') ? 9 : 0;
		
		$tempsave = array('email' => $_POST['email'], 'first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name'], 'user_level' => $userlevelnow);
		$this->Mvcadv_user_model->update($tempsave);
		$data['message'] = "Update Successful";
		}
		else
		$data['message'] = "Sorry, email is not in database to UPDATE";
		
		
		echo json_encode($data);
	}
	
	public function updatepw()
	{
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'min_length[6]|required');		
		$this->form_validation->set_rules('conf_pw', 'Password', 'min_length[6]|required|matches[password]');	
		
		if($this->form_validation->run() === FALSE)
		{

			$data['message'] = validation_errors();
			echo json_encode($data);
		}
		else
		{

			$this->load->model('Mvcadv_user_model');
			$this->load->library('encrypt');
			$newpw = array('id' => $_POST['whoisit'], 'password' => $this->encrypt->encode($_POST['password']));

			if ($this->user_session['id'] == $_POST['whoisit'])
			{
			$this->Mvcadv_user_model->update_own_pw($newpw);
			}
			else
			{$this->Mvcadv_user_model->update_pw($newpw);}
			
			
			$data['message'] = "Password change successful!";
			echo json_encode($data);	
		}
		
		
	}
	
	public function editdescript()
	{
	
		$this->load->model('Mvcadv_user_model');
		$changeit = array('email' => $_POST['email'], 'description' => $_POST['textareadesc']);
		$this->Mvcadv_user_model->update($changeit);
		$data['descmessage'] = 'Description Succesfully saved!';
		echo json_encode($data);
			
	}
	
	public function inputwallcontent()
	{
	
		if ($_POST['textarea'] != '')
		{
			$data = array('user_id' => $_POST['whoisit'], 'author_id' => $this->session->userdata['user_session']['id'],'message' => $_POST['textarea'], 'created_at' => date('Y-m-d H:i:s'));
			$this->load->model('Mvcadv_user_model');
			
			$this->Mvcadv_user_model->insert_message($data);
			echo json_encode('');
			
		}
			
	}
	
	public function postcomment()
	{
		
		if ($_POST['textarea'] != '')
		{
			$data = array('message_id' => $_POST['whichmessage'], 'author_id' => $this->session->userdata['user_session']['id'],'comment' => $_POST['textarea'], 'created_at' => date('Y-m-d H:i:s'));
			$this->load->model('Mvcadv_user_model');
			
			$this->Mvcadv_user_model->insert_comment($data);
			echo json_encode('');
			
			
		}
			
	}
	
	public function getallmessages()
	{	
		$data = array('id' => $_POST['whoisit']);
		
		$this->load->model('Mvcadv_user_model');
		$results = $this->Mvcadv_user_model->user_messages($data);
		//var_dump($results);
		//$comments = $this->Mvcadv_user_model->comments($data);
		
		$html = "";
		foreach( $results as $result)
		{			
			$html .= $result->first_name . " " . $result->last_name . "on: ".$result->created_at."wrote: 
			<div class ='message'>" . $result->message ."</div><br/><div id ='commentMsg'>";
			
			$comment = $this->getallComments($result->id);
			
			$html .= $comment;
			
			
			
			$html .="<form id ='postpost' method ='post' class = 'postcomment' action ='/users/postcomment'><input type ='hidden' name='whichmessage' value = '".$result->id."'><textarea name ='textarea' class='commentarea' rows='8'></textarea><input type ='submit' value ='Post Comment'/></form></div>";	

				
		}
		
		
		
		$temp = array();
		$temp['html'] = $html;
		//var_dump($temp);
	
		echo json_encode($temp);
			
	}
	
	public function getallComments($id)
	{
		
		$this->load->model('Mvcadv_user_model');
		$comments = $this->Mvcadv_user_model->get_comments($id);
		
		//$comments = $this->Mvcadv_user_model->user_comments($data);
		//var_dump($results);
		//$comments = $this->Mvcadv_user_model->comments($data);
		
		$html = "";
		foreach( $comments as $comment)
		{			
			$html .= $comment->first_name . " " . $comment->last_name . "on: ".$comment->created_at."wrote: 
			<div class ='commenttext'>" . $comment->comment ."</div><br/></div>";			
		}
		
		return $html;
			
	}	
}

?>