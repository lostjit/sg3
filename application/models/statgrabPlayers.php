<?php
date_default_timezone_set('America/New_York');

class statgrabPlayers extends CI_Model
{
	public function __construct()
	{
		parent::__construct();		
		mysql_query('SET CHARACTER SET utf8');	
	}
	


	public function getallplayers()
	{
		$query = $this->db->query("SELECT first_name, last_name, id from players order by last_name asc");
		return $query->result();	
	}
	
	public function getresults($query)
	{

		
		$query = str_replace("delete", "", strtolower($query));
		$query = str_replace("alter", "", strtolower($query));
		$query = str_replace("drop", "", strtolower($query));
		


		$test = $this->db->query($query);
		
		return $test->result();
		
	}
	

	
	
}














?>