<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Main extends CI_Controller {

	protected $user_session = NULL;
	protected $view_data = array();
	
	public function __construct()
	{
		parent::__construct();
		//$this->user_session = $this->session->userdata('user_session');	
	}
	
	
		
	public function logoff()
	{
		$this->session->sess_destroy();
		redirect('advanceci/index');
	}
	
}	



?>