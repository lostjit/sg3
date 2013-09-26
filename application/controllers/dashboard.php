<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require('main.php');


class Dashboard extends Main {

	public function __construct(){	
		
		parent::__construct();

	}


	public function index()
	{
		
		if ($this->user_session['user_level'] == 9)
		{
			$this->admin();
		}
		else
		{			
			$this->load->view('normalDash', $this->displayTable());			
		}
	}
	
	public function admin()
	{
		
		if (isset($this->session) && ($this->session->userdata['user_session']['user_level'] == 9))
		$this->load->view('admin', $this->displayTable());
		else
		redirect("advanceCi/index");
	}
	
	public function addnewuser()
	{
		$this->load->view('newuserview');
	}
	
	public function editprofile()
	{
		$data = array('email' => $this->session->userdata['user_session']['email'], 'first_name' => $this->session->userdata['user_session']['first_name'], 'last_name' => $this->session->userdata['user_session']['last_name'], 'user_level' =>$this->session->userdata['user_session']['user_level'], 'description' => $this->session->userdata['user_session']['description']);
		
		$this->load->view('editownprofile', $data);
	}
	
	public function adminuseredit()
	{
		$this->load->view('useredit');
	}

	
	public function displayTable()
	{
	
		$this->load->model('mvcadv_user_model');
		$allusers = $this->mvcadv_user_model->get_all();
		if ($this->session->userdata['user_session']['user_level'] == 9)
		{			
			$admin = TRUE;
			$actions = "<th>Actions</th></thead>";
			$gohere = 'admin';
			
		}
		else
		{
			$admin = FALSE;
			$actions = "</thead>";
			$gohere = "index";
		}		
		
		$html = "<table class ='table table-striped'><thead><tr><th>ID</th><th>name</th><th>Email</th><th>Created At</th><th>User Level</th>".$actions."<tbody>";
		
		foreach($allusers->result() as $row)
		{
			
			
			if ($this->session->userdata['user_session']['email'] == $row->email)
			{
				$html .= "";
			}
			else
			{		
			
				$html .= "<form class ='admineditremove' method = 'post' action = '/dashboard/editorremove'><input type = 'hidden' class = 'targetthis' name='whoisit' value ='". $row->id  ."'/><tr><td>" . $row->id  . "</td><td><a href ='/users/showprofile/".$row->id ."'>".$row->first_name ." " . $row->last_name ."</a></td><td>" . $row->email . "</td><td>" . $row->created_at . "</td><td>". $row->user_level ."</td>";
				
				if($admin)
				{
				
					$html .= "<td><input type = 'submit' name='edituser' value ='edit'/>			
					<!-- Button to trigger modal -->
					<a href='#myModal".$row->id ."' role='button' class='btn' data-toggle='modal'>Remove</a>
					 
					<!-- Modal -->
					<div id='myModal".$row->id."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
					  <div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
						<h3 id='myModalLabel'>Modal header</h3>
					  </div>
					  <div class='modal-body'>
						<p>Are you sure you want to remove this user?</p>
					  </div>
					  <div class='modal-footer'>
						<button class='btn' data-dismiss='modal' aria-hidden='true'>Close</button>
						<input type = 'submit' id = 'removeuser' class = 'btn' name='removeuser' value = 'Remove'/>
					  </div>
					</div>
					 </form></td>";			
				}
				else
				{
				 $html .= "</form>";
				}		
			}
		}
		
		
		$html .= "</tbody></table>";
		
		$view_data['table'] = $html;
		return $view_data;
		
		}
	
	public function editorremove()
	{		
		if (Isset($_POST['removeuser']) && $_POST['removeuser'] == 'Remove')
		{
			$this->load->model('mvcadv_user_model');
			$this->mvcadv_user_model->remove($_POST);		
		}
		else if (Isset($_POST['edituser']) && $_POST['edituser'] == 'edit')
		{			
			$this->load->model('mvcadv_user_model');
			$userinfo = $this->mvcadv_user_model->get_user_info($_POST['whoisit']);
			
			$data = array('email' => $userinfo->email, 'first_name' => $userinfo->first_name, 'last_name' => $userinfo->last_name, 'id' => $userinfo->id, 'adminornot' => true);
			
			$this->load->view('useredit', $data);
		}
		else //assuming the only other way to get in here is using "edit my profile"
		{
			$data = array('email' =>$this->session->userdata['user_session']['email'], 'first_name' => $this->session->userdata['user_session']['first_name'], 'last_name' => $this->session->userdata['user_session']['last_name'], 'id' => $this->session->userdata['user_session']['email'], 'adminornot' => false);
			
			$this->load->view('useredit', $data);		
		}		
	}
}
?>