<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/New_York');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$players= array('players2' => $this->getDDLplayers());

		$this->load->view('welcome_message', $players);
	}
	
	public function faq()
	{
		$this->load->view('faq');
	}


	public function contact()
	{
		$this->load->view('contactform');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');
	}

	public function submitform()
	{
		
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('name', 'Name', 'alpha|required');
		$this->form_validation->set_rules('comment', 'Comment', 'required');
		$this->form_validation->set_rules('regarding', 'Regarding', 'required');


		if ($_POST['phone'] != null)
		{
			header("location: http://www.google.com");
			die();
		}

		if($this->form_validation->run() === FALSE)
		{
			$data['message'] = validation_errors();
			$this->load->view('contactform', $data);
		}
		else
		{
				//need to set up email
		 //    		$email_subject = "New email - statgrab -" . $_POST['regarding'] ;
			// 	 $headers = "From: " .$_POST['email'] ."\r\n";
 		// 			$message = $_POST['comment'];
  					
			// mail('lostjit@example.com', $email_subject, $message, $headers);
		
		}
	}

	protected function getDDLplayers()
	{
		$this->load->model('statgrabPlayers');
		$results = $this->statgrabPlayers->getallplayers();
		

		$selectlist = "<select id = 'ddlIndivs' name = 'ddlIndivs'>";
	
		foreach ($results as $result)
		{
		
			$selectlist .= "<option value = '".$result->id."'>".$result->last_name.", " . $result->first_name . "</option>";
		
		}
		
		$selectlist .= "</select>";	

	
		return $selectlist;
		
		
	}
	
	
	
	public function whatstat(){ //function to decide whether you're running a team query or individual query
	
		if (isset($_POST['action']))
			$this->indivwhatfields();
		else
		{
			
				if ($_POST['ddlteamchoice'] == $_POST['against'] AND $_POST['ddlteamchoice'] != 'all')
				{
					$mainjsondata['intro'] = "Sorry, we could not find any stats to grab for that search.";
					echo json_encode($mainjsondata);
				}
			else
			$this->teamwhatfields();
		}
	
	
	}
	
	public function test() //first function entered
	{
		
		
		$this->teamwhatfields();
		
		// if ($this->whatstat())
		// {
			// $runthis = $this->indivwhatfields();
		// }
		// else
		// {
		// }
		
		
		
	}
	
	public function indivwhatfields() //func to see what indivs fields we need to get from sql
	{	
			//this is part of the SELECT part of sql
					
			$tablecats = "";
			$stat = array();
			
			if (isset($_POST['option1']))
			{
				$run1 = ",receptions";
				$tablecats .= "<th>Receptions</th>";				
				$stat[] = 1;
			}
			else
			$run1 = "*";
			if (isset($_POST['option2']))
			{
				$run2 = ",receivingYards";
				$tablecats .= "<th>Receiving Yards</th>";
				$stat[] = 2;
			}
			else
			$run2 = "*";
			if (isset($_POST['option3']))
			{
				$run3 = ",passingyards";
				$tablecats .= "<th>Passing Yards</th>";
				$stat[] = 3;
			}
			else
			$run3 = "*";
			if (isset($_POST['option4']))
			{
				$run4 = ",rushingYards";
				$tablecats .= "<th>Rushing Yards</th>";
				$stat[] = 4;
			}
			else
			$run4 = "*";
			if (isset($_POST['option5']))
			{
				$run5 = ",receivingtouchdowns";
				$tablecats .= "<th>Receiving Touchdowns</th>";
				$stat[] = 5;
			}
			else
			$run5 = "*";
			if (isset($_POST['option6']))
			{
				$run6 = ",rushingtouchdowns";
				$tablecats .= "<th>Rushing Touchdowns</th>";
				$stat[] = 6;
			}
			else
			$run6 = "*";
			if (isset($_POST['option7']))
			{
				$run7 = ",passtouchdowns";
				$tablecats .= "<th>Passing Touchdowns</th>";
				$stat[] = 7;
			}
			else
			$run7 = "*";
			if (isset($_POST['option8']))
			{
				$run8 = ",interceptions";
				$tablecats .= "<th>Interceptions</th>";
				$stat[] = 8;
			}
			else
			$run8 = "*";
			if ($_POST['allstats'] == "all")
			{
				$run0 = "bleh";
				$stat[] = 9;
				$tablecats .= "<th>Receptions</th><th>Receiving YRDs</th><th>Passing YRDs</th><th>Rushing YRDs</th><th>Receiving TDs</th><th>Rushing TDs</th><th>Passing TDs</th><th>INTs</th>";
			}
			else $run0 = "";			
			
				if ($_POST['noextra'] == 'yesextra')
				{					
					switch ($_POST['month'])
					{
						case "All":
							
							break;
						case "September":
							$run9 = " AND (date LIKE '%-09-%')";
							break;
						case "October":
							$run9 = " AND (date LIKE '%-10-%')";
							break;
						case "November":
							$run9 = " AND (date LIKE '%-11-%')";
							break;
						case "December":
							$run9 = " AND (date LIKE '%-12-%')";
							break;
						case "January":
							$run9 = " AND (date LIKE '%-01-%')";
							break;			
					}
					
					if (isset($_POST['timeofday']))
					{
						switch ($_POST['timeofday'])
						{
							case 'All': 
								
								break;
							case 'Morning': 
								$run10 = " AND (time < '14:00:00')";
								break;
							case 'Afternoon': 
								$run10 = " AND (time >= '14:00:00' and time < '17:30:00')";
								break;
							case 'Night': 
								$run10 = " AND (time >= '17:30:00')";
								break;						
						}				
					}		
				}
				
				//populate our select statement
				if ($run0 == "bleh")
					{
						$temp = ",receptions,receivingYards,passingyards,rushingYards,receivingtouchdowns,rushingtouchdowns,passtouchdowns,interceptions";
					}
				else
					{						
						$mainselect =  $run1.$run2.$run3.$run4.$run5.$run6.$run7.$run8."";
						$temp = "";
						for ($i = 0; $i < strlen($mainselect); $i++)
						{
							if ($mainselect[$i] == '*')
								{}
							else
								$temp .= $mainselect[$i];
						}					
					}
				
			
				//populate our where statement
				
				if (isset($run9) AND isset($run10))
				{
				$where = " where (game.id like '%%')".$run9.$run10;
			
				}
				elseif (isset($run9) AND !isset($run10))
				{
				$where = " where (game.id like '%%')".$run9;
			
				}
				elseif (!isset($run9) AND isset($run10))
				{
				$where = " where (game.id like '%%')".$run10;
				
				}
				elseif (!isset($run9) AND !isset($run10))
				{
				$where = " where (game.id like '%%')";
				
				}				
				
				if ($_POST['against'] == 'all')
				{
					$where .= "";
				}
				else
				{
					$where .= " AND ((hometeam = '".$_POST['against']."') OR (awayteam = '".$_POST['against']."'))";
				}
				
				
				$person = " AND (player_id = ".$_POST['ddlIndivs'].")";
				
				
				
				$query = "SELECT game.ID, date, hometeam, awayteam, home1stqscore,home2ndqscore,home3rdqscore,home4thqscore,homeovertimescore,away1stqscore,away2ndqscore,away3rdqscore,away4thqscore,awayovertimescore, concat_WS(' ', first_name, last_name) as fullname ".$temp. " from game_has_players left join 
					game on game.id = game_has_players.game_id LEFT JOIN players on game_has_players.player_id = players.id".$where.$person. " ORDER BY date desc";
				
				

				
				$this->load->model('statgrabPlayers');
				$results = $this->statgrabPlayers->getresults($query);
				
				if (count($results) == 0)
				{
					$poop1['averages'] = "";
					$poop1['gamestats'] = "Sorry, we could not find any stats to grab for that search.";
					echo json_encode($poop1);	
				}
				else
				{
					$poop1 = $this->indivtable($results, $tablecats, $stat);		
					echo json_encode($poop1);
				}
	}
	
	
	public function indivtable($arr, $tablecats, $stat)
	{	//this function belongs to the individual stat		
		
		$recaverage = "";
		$recyardaverage = "";
		$rushyardaverage = "";
		$passyardaverage = "";
		$rectdaverage = "";
		$rushtdaverage = "";
		$passtdaverage = "";
		$intaverage = "";			
		
		$html = "<table class = 'indivtable'><thead><tr><th>Date</th>".$tablecats."<th>Home Team</th><th>Home Final</th><th>Away Team</th><th>Away Final</th></tr><tbody>";

		foreach($arr as $game)
		{			

				$tablestats = "";
				for ($i=0; $i<count($stat); $i++)
				{
					switch($stat[$i])
					{
						case '1': 
							$tablestats .= "<td>".$game->receptions."</td>";
							$recaverage += $game->receptions;
							break;
						case '2': 
							$tablestats .= "<td>".$game->receivingyards."</td>";
							$recyardaverage += $game->receivingyards;
							break;
						case '3': 
							$tablestats .= "<td>".$game->passingyards."</td>";
							$passyardaverage += $game->passingyards;
							break;
						case '4': 
							$tablestats .= "<td>".$game->rushingYards."</td>";	
							$rushyardaverage += $game->rushingYards;
							break;	
						case '5': 
							$tablestats .= "<td>".$game->receivingtouchdowns."</td>";
							$rectdaverage += $game->receivingtouchdowns;
							break;
						case '6': 
							$tablestats .= "<td>".$game->rushingtouchdowns."</td>";
							$rushtdaverage += $game->rushingtouchdowns;
							break;
						case '7': 
							$tablestats .= "<td>".$game->passtouchdowns."</td>";
							$passtdaverage += $game->passtouchdowns;
							break;
						case '8': 
							$tablestats .= "<td>".$game->interceptions."</td>";
							$intaverage += $game->interceptions;
							break;
						case '9': 



						
							$tablestats .= "<td>".$game->receptions."</td><td>".$game->receivingyards."</td><td>".$game->passingyards."</td><td>".$game->rushingyards."</td><td>".$game->receivingtouchdowns."</td><td>".$game->rushingtouchdowns."</td><td>".$game->passtouchdowns."</td><td>".$game->interceptions."</td>";
							$recaverage += $game->receptions;
							$recyardaverage += $game->receivingyards;
							$passyardaverage += $game->passingyards;
							$rushyardaverage += $game->rushingyards;
							$rectdaverage += $game->receivingtouchdowns;
							$rushtdaverage += $game->rushingtouchdowns;
							$passtdaverage += $game->passtouchdowns;
							$intaverage += $game->interceptions;							
							break;							
					}	
				}
		
			$homeovertime = ($game->homeovertimescore != -1) ? $game->homeovertimescore : 0;
			$awayovertime = ($game->awayovertimescore != -1) ? $game->awayovertimescore : 0;
			$totalhome = $game->home1stqscore + $game->home2ndqscore + $game->home3rdqscore + $game->home4thqscore + $homeovertime;
			$totalaway = $game->away1stqscore + $game->away2ndqscore + $game->away3rdqscore + $game->away4thqscore + $awayovertime;
		
			$html .= "<tr><td>".date('F d Y', (strtotime($game->date)))."</td>".$tablestats . "<td>" . $game->hometeam."</td><td>".$totalhome."</td><td>".$game->awayteam."</td><td>".$totalaway."</tr>";	
		}
		
		$avgtable = "<div id ='averageindiv'><h1>".$arr[0]->fullname."</h1>" . "<br/>Per Game Average (out of ".count($arr)." games):<br/><table>";
		
		$avgtable .= ($recaverage != NULL) ? "<tr><th>Average Receptions</th><td>" . number_format($recaverage/count($arr),2) . "</td></tr>" : "";
		
		$avgtable .= ($recyardaverage != NULL) ? "<tr><th>Average Receiving Yards</th><td>" . number_format($recyardaverage/count($arr),2) . "</td></tr>" : "";
		
		$avgtable .= ($rushyardaverage != NULL) ? "<tr><th>Average Rushing Yards</th><td>" . number_format($rushyardaverage/count($arr),2) . "</td></tr>" : "";
		
		$avgtable .= ($passyardaverage!= NULL) ? "<tr><th>Average Passing Yards</th><td>" . number_format($passyardaverage/count($arr),2) . "</td></tr>" : "";
		
		$avgtable .= ($rectdaverage!= NULL) ? "<tr><th>Average Receiving TDs</th><td>" . number_format($rectdaverage/count($arr),2) . "</td></tr>" : "";
		
		$avgtable .= ($rushtdaverage!= NULL) ? "<tr><th>Average Rushing TDs</th><td>" . number_format($rushtdaverage/count($arr),2) . "</td></tr>" : "";
		
		$avgtable .= ($passtdaverage!= NULL) ? "<tr><th>Average Passing TDs</th><td>" . number_format($passtdaverage/count($arr),2) . "</td></tr>" : "";
		
		$avgtable .= ($intaverage!= NULL) ? "<tr><th>Average Interceptions Thrown</th><td>" . number_format($intaverage/count($arr),2) . "</td></tr>" : "";	
		
		$avgtable .= "</table></div>";		
		$html .= "</tbody>";	
	
		$resultsindiv = array();
		$resultsindiv['gamestats'] = $html;
		$resultsindiv['averages'] = $avgtable;
		
		return $resultsindiv;
	}
	
	
	public function teamwhatfields()
	{
			$mainjsondata = array();
			







			$tablecats = "";
			$stat = array();
			
			if (isset($_POST['option1']))
			{
				$run1 = "*";
				$tablecats .= "<th>W or L</th>";				
				$stat[] = 1;
			}
			
		
			if (isset($_POST['option2']))
			{
				$run2 = "*";
				$tablecats .= "<th>Points Allowed</th>";
				$stat[] = 2;
			}

			if (isset($_POST['option2']))
			{
				$run2 = "*";
				$tablecats .= "<th>Points Scored</th>";
				$stat[] = 2;
			}
			
			// if ($_POST['allstats'] == "all")
			// {
			// 	$run0 = "*";
			// 	$stat[] = 9;
			// }	
				


			
			$ifplusspread ='@';
				$ifminusspread = '@';


			if (($_POST['option9'] == 'nospread') or (($_POST['option9'] == 'spread' AND !isset($_POST['spread']))) or (($_POST['option9'] == 'spread' AND $_POST['spread'] == 0)))
			{
			$run9 = "";
			$run10 = "";
			$gamespread = "";
			}
			else
			{
				if (strpos($_POST['spread'], '.'))
					$gamespread = $_POST['spread'];
				else
					$gamespread = $_POST['spread'].".0";

					if ($_POST['spread'] > 0)
					{
					
						if ($_POST['ddlteamchoice'] != 'all')
						{
							if ($_POST['against'] != 'all')
							{
								$ifplusspread = " AND (plusteam ='".$_POST['ddlteamchoice']."' AND plusteamspread = ".$gamespread .") AND minusteam = '".$_POST['against']."'";
							}
							else
							{
							$ifplusspread = " AND (plusteam ='".$_POST['ddlteamchoice']."' AND plusteamspread = ".$gamespread .")";
							}
						}
						else //if ddlteamchoice is all
						{								

							if ($_POST['against'] != 'all')
							{
								$ifplusspread = " AND plusteamspread = ".$gamespread ." AND minusteam = '".$_POST['against']."'";
							}
							else
							{
							$ifplusspread = " AND plusteamspread = ".$gamespread ."";
							}

						}
					}


					else if ($_POST['spread'] < 0)
					{
							
						if ($_POST['ddlteamchoice'] != 'all')
						{
							if ($_POST['against'] != 'all')
							{
								$ifplusspread = " AND (minusteam ='".$_POST['ddlteamchoice']."' AND minusteamspread = ".$gamespread .") AND plusteam = '".$_POST['against']."'";
							}
							else
							{
							$ifplusspread = " AND (minusteam ='".$_POST['ddlteamchoice']."' AND minusteamspread = ".$gamespread .")";
							}
						}
						else //if ddlteamchoice is all
						{								

							if ($_POST['against'] != 'all')
							{
								$ifplusspread = " AND minusteamspread = ".$gamespread ." AND plusteam = '".$_POST['against']."'";
							}
							else
							{
							$ifplusspread = " AND minusteamspread = ".$gamespread ."";
							}

						}

					}








				
				if (isset($_POST['totalpointspread']))
				{		
					if (strpos($_POST['totalpointspread'], '.'))
						$totalpointspread = $_POST['totalpointspread'];
						else
						$totalpointspread = $_POST['totalpointspread'] . ".0";	
						
				}
			}
		
		

			$allspread = "@";
			if ($_POST['ddlteamchoice'] == 'all')
			{
				$whatteam = '(id like "%%")';
				if (isset($_POST['spread']))
				{
					if ($_POST['homeoraway'] == 'Home')
					{
						if ($_POST['spread'] > 0)
						{
							$allspread = ' AND game.hometeam = game.plusteam';
						}
						else if ($_POST['spread'] < 0)
						{
							$allspread = ' AND game.hometeam = game.minusteam';
						}					
					}

					if ($_POST['homeoraway'] == 'Away')
					{
						if ($_POST['spread'] > 0)
						{
							$allspread = ' AND game.awayteam = game.plusteam';
						}
						else if ($_POST['spread'] < 0)
						{
							$allspread = ' AND game.awayteam = game.minusteam';
						}					
					}
				}
				
			}
			else
			{
				$whatteam = " ((hometeam = '".$_POST['ddlteamchoice']."') OR (awayteam = '".$_POST['ddlteamchoice']."'))";
			}
			
				if ($_POST['against'] == 'all')
				{
					$where = "";
				}
				else
				{
					$where = " AND ((hometeam = '".$_POST['against']."') OR (awayteam = '".$_POST['against']."'))";
				}
		
		


			// if ($_POST['option9'] == 'nospread')
			// {

			// 	$ifplusspread .=' AND gamespread LIKE "%%"';
			// 	$ifminusspread .= ' AND gamespread LIKE "%%"';
				

			// }
			// else
			// {
			// 	$ifplusspread .=' AND gamespread LIKE "%'.$gamespread.'%"';
			// 	$ifminusspread .=' AND gamespread LIKE "%%"';
				
			// }




			$overunder = "";
			if (isset($_POST['totalspread']))
			{
				if ($_POST['totalspread'] == 'all')
					{}
				else{
					if (strpos($_POST['totalspread'], '.'))
						$gamespread2 = $_POST['totalspread'];
						else
						$gamespread2 = $_POST['totalspread'] . ".0";
				
						
					$overunder = " AND overunder = ".$gamespread2."";
				}
				
			}
		
				

			//part of game
			//$partofgame = 0;
			$run11 = "@";
			switch($_POST['partofgame'])
			{

				case 'First Half':
					//$partofgame = 1;
					$table1 = "<td class ='highlight'>1Q</td><td class ='highlight'>2Q</td><td>3Q</td><td>4Q</td>";
					break;

				case 'Second Half':
					//$partofgame = 2;
					$table1 = "<td>1Q</td><td>2Q</td><td class ='highlight'>3Q</td><td class ='highlight'>4Q</td>";
					break;
				case '1st Quarter':
					//$partofgame = 3;
					$table1 = "<td class ='highlight'>1Q</td><td>2Q</td><td>3Q</td><td>4Q</td>";
					break;
				case '2nd Quarter':
					//$partofgame = 4;
					$table1 = "<td>1Q</td><td class ='highlight'>2Q</td><td>3Q</td><td>4Q</td>";
					break;
				case '3rd Quarter':
					//$partofgame = 5;
					$table1 = "<td>1Q</td><td>2Q</td><td class ='highlight'>3Q</td><td>4Q</td>";
					break;
				case '4th Quarter':
					//$partofgame = 6;
					$table1 = "<td>1Q</td><td>2Q</td><td>3Q</td><td class ='highlight'>4Q</td>";
					break;
				case 'Overtime':
					$table1 = "<td>1Q</td><td>2Q</td><td>3Q</td><td>4Q</td>";
					$run11 = " AND homeovertimescore != -1";
				default:
					//$partofgame = 9;
					$table1 = "<td>1Q</td><td>2Q</td><td>3Q</td><td>4Q</td>";
					break;

			}

			$homeaway = 0;
			switch($_POST['homeoraway'])
			{
				case 'Home':

					if ($_POST['ddlteamchoice'] != "all")
						$whatteam = ' hometeam = "'.$_POST['ddlteamchoice'].'"';
					if ($_POST['against'] != 'all')
						$where = ' and awayteam = "'.$_POST['against'].'"';
					$table4 = "<tr class ='homeoraway'>";
					$table7 = "<tr>";
						break;
				case 'Away':
					if ($_POST['ddlteamchoice'] != "all")
						$whatteam = ' awayteam = "'.$_POST['ddlteamchoice'].'"';
					if ($_POST['against'] != 'all')
						$where = ' and hometeam = "'.$_POST['against'].'"';
					$table4 = "<tr>";
					$table7 = "<tr class ='homeoraway'>";
						break;
				default:
					$homeaway = 9;
					$table4 = "<tr>";
					$table7 = "<tr>";
			}

			$run12 = '@';
			if (isset($_POST['whatday']))
			{

				if ($_POST['whatday'] != 0)
				{
					$run12 = ' AND dayofweek(date) = '.$_POST['whatday'].'';
				}
				

			}

				$run9 = "@";
				$run10 = "@";
		if ($_POST['noextra'] == 'yesextra' && isset($_POST['month']))
				{					
					switch ($_POST['month'])
					{
						case "All":
							$run9 = "@";
							break;
						case "September":
							$run9 = " AND (date LIKE '%-09-%')";
							break;
						case "October":
							$run9 = " AND (date LIKE '%-10-%')";
							break;
						case "November":
							$run9 = " AND (date LIKE '%-11-%')";
							break;
						case "December":
							$run9 = " AND (date LIKE '%-12-%')";
							break;
						case "January":
							$run9 = " AND (date LIKE '%-01-%')";
							break;			
					}

					if (isset($_POST['timeofday']))
					{
						switch ($_POST['timeofday'])
						{
							
							case 'Morning': 
								$run10 = " AND (time < '14:00:00')";
								break;
							case 'Afternoon': 
								$run10 = " AND (time > '14:00:00' and time < '17:30:00')";
								break;
							case 'Night': 
								$run10 = " AND (time > '17:30:00')";
								break;	
							default:
								$run10 = "@";
								break;				
						}		
						$table5 = "<td class ='timeofgame'>Time of Game</td>";
					}	
					}
					else
						$table5 = "*";
		
		$selectteam = "SELECT game.id,date,time,hometeam,minusteamspread,minusteam,plusteam, minusteamcover,plusteamcover,ouresult, overunder,awayteam,home1stqscore,home2ndqscore,home3rdqscore,home4thqscore,homeovertimescore,away1stqscore,away2ndqscore,away3rdqscore,away4thqscore,awayovertimescore FROM game WHERE " . $whatteam . $ifplusspread . $ifminusspread . $where . $overunder . $run9 . $run10 . $run11 . $run12 . $allspread . " ORDER BY date desc";

		$selectteam = str_replace("@", "", $selectteam);


		
		
		$tableheading1 = "<table class = 'clearboth'><thead><tr><th>Team</th>".$table1."<td class ='total'>Total</td></tr></thead>";

		$tableheading1 = str_replace("*", "", $tableheading1);

		$tableheading2 = "<table class = 'clearboth'><thead><tr><th>Team</th>".$table1."<td>OT</td><td class ='total'>Final</td></tr></thead>";

		$tableheading2 = str_replace("*", "", $tableheading2);



	

		$this->load->model('statgrabPlayers');
				$results = $this->statgrabPlayers->getresults($selectteam);
		
	if (count($results) == 0)
		{
			$mainjsondata['intro'] = "Sorry, we could not find any stats to grab for that search.";
			$mainjsondata['allgames'] = "";
			$mainjsondata['quicksum'] = "";
			$mainjsondata['vegassum'] = "";
			$mainjsondata['teamsum'] = "";
			echo json_encode($mainjsondata);	
		}
	else
	{

			$gamecount = 0;
			$total1stQH = 0;
			$total2ndQH = 0;
			$total3rdQH = 0;
			$total4thQH = 0;
			$totalOTH = 0;
			
			$total1stQA = 0;
			$total2ndQA = 0;
			$total3rdQA = 0;
			$total4thQA = 0;
			$totalOTA = 0;

			$favteamcov = 0;
			$underdogcov = 0;
			$overresult = 0;
			$underresult = 0;
			$won = 0;

			if ($_POST['ddlteamchoice'] != 'all')
			{
				$pickedteamtotalpts = 0;
				$pickedavg1q = 0;
				$pickedavg2q = 0;
				$pickedavg3q = 0;
				$pickedavg4q = 0;


				$pickedteampluscover = 0;
				$pickedteamminuscover = 0;
				$teamisplusgames = 0;
				$teamisminusgames = 0;
			}

			if ($_POST['ddlteamchoice'] == 'all' AND $_POST['homeoraway'] != 'both')
			{
				if ($_POST['homeoraway'] == 'Home')	
				{
					$hometeamcov = 0;
					$hometeamminuscov = 0;
					$hometeamplusgames = 0;
					$hometeamminusgames = 0;
				}
				else //if team is away
				{
					$awayteamcov = 0;
					$awayteamminuscov = 0;
					$awayteamplusgames = 0;
					$awayteamminusgames = 0;

				}
			}




			if ($_POST['against'] != 'all')
			{
				$againstteamtotalpts = 0;
				$againstavg1q = 0;
				$againstavg2q = 0;
				$againstavg3q = 0;
				$againstavg4q = 0;

				$againstteampluscover = 0;
				$againstteamminuscover = 0;
				$againstplusgames = 0;
				$againstisminusgames = 0;
			}


			$allgameresults = "";
foreach($results as $result)
{


		
			$gamecount++;
			$total1stQH += $result->home1stqscore;
			$total2ndQH += $result->home2ndqscore;
			$total3rdQH += $result->home3rdqscore;
			$total4thQH += $result->home4thqscore;
		
			$total1stQA += $result->away1stqscore;
			$total2ndQA += $result->away2ndqscore;
			$total3rdQA += $result->away3rdqscore;
			$total4thQA += $result->away4thqscore;



			if ($_POST['ddlteamchoice'] == 'all' AND $_POST['homeoraway'] != 'both')
			{
				if ($_POST['homeoraway'] == 'Home')	
					if ($result->hometeam == $result->plusteam)
					{	
						$hometeamplusgames++;
						if ($result->plusteamcover == 1)
							$hometeamcov++;
					}
					else
					{	
						$hometeamminusgames++;
						if ($result->minusteamcover == 1)
							$hometeamminuscov++;
					}
				else //if team is away
					if ($result->awayteam == $result->plusteam)
					{	
						$awayteamplusgames++;
						if ($result->plusteamcover == 1)
							$awayteamcov++;
					}
					else
					{
						$awayteamminusgames++;
						if ($result->minusteamcover == 1)
							$awayteamminuscov++;
					}
			}
			
			if ($_POST['ddlteamchoice'] != 'all') //conditions if user selects a main team
			{

				if ($result->hometeam == $_POST['ddlteamchoice'])
				{
					$pickedavg1q += $result->home1stqscore;
					$pickedavg2q += $result->home2ndqscore;
					$pickedavg3q += $result->home3rdqscore;
					$pickedavg4q += $result->home4thqscore;

					$pickedteamtotalpts +=  $result->home1stqscore +  $result->home2ndqscore + $result->home3rdqscore + $result->home4thqscore;
					if ($result->homeovertimescore != -1)
					{
						$pickedteamtotalpts += $result->homeovertimescore;
					}
				}
				else //means team is away
				{
					$pickedavg1q += $result->away1stqscore;
					$pickedavg2q += $result->away2ndqscore;
					$pickedavg3q += $result->away3rdqscore;
					$pickedavg4q += $result->away4thqscore;

					$pickedteamtotalpts +=  $result->away1stqscore +  $result->away2ndqscore + $result->away3rdqscore + $result->away4thqscore;
					if ($result->awayovertimescore != -1)
					{
						$pickedteamtotalpts += $result->awayovertimescore;
					}

				}	


				if ($result->plusteam == $_POST['ddlteamchoice'])
				{
						$teamisplusgames++;
					if ($result->plusteamcover == 1)
						$pickedteampluscover++;
				}
				else //meaning the team chosen is underdog
				{
						$teamisminusgames++;
					if ($result->minusteamcover == 1)
						$pickedteamminuscover++;
				}
			}



			if ($_POST['against'] != 'all') //conditions if user selects an against team
			{
				if ($result->hometeam == $_POST['against'])
				{
					$againstteamtotalpts +=  $result->home1stqscore +  $result->home2ndqscore + $result->home3rdqscore + $result->home4thqscore;
					if ($result->homeovertimescore != -1)
					{
						$againstteamtotalpts += $result->homeovertimescore;
					}
				}
				else //means team is away
				{
					$againstteamtotalpts +=  $result->away1stqscore +  $result->away2ndqscore + $result->away3rdqscore + $result->away4thqscore;
					if ($result->awayovertimescore != -1)
					{
						$againstteamtotalpts += $result->awayovertimescore;
					}

				}	


				if ($result->plusteam == $_POST['against'])
				{
						$againstplusgames++;
					if ($result->plusteamcover == 1)
						$againstteampluscover++;
				}
				else //meaning the team chosen is underdog
				{
						$againstisminusgames++;
					if ($result->minusteamcover == 1)
						$againstteamminuscover++;
				}
			}





			
			$homegamefinal = $result->home1stqscore +  $result->home2ndqscore +  $result->home3rdqscore +  $result->home4thqscore;
			$awaygamefinal = $result->away1stqscore +  $result->away2ndqscore +  $result->away3rdqscore +  $result->away4thqscore;

			if ($result->minusteamcover == 1)
			{
				$coveranswer = "Yes";
				$favteamcov++;
			}
			else
			{
				$coveranswer = "No";
			}

			if ($result->plusteamcover == 1)
			{
				$underdogcov++;
			}
			




			switch($result->ouresult)
			{
							case 'OVER': 
								$overresult++;
								break;
							case 'UNDER': 
								$underresult++;
								break;	
							default:
								break;	
			}
			


			if ($result->homeovertimescore != -1)
				{
					$totalOTA += $result->awayovertimescore;
					$totalOTH += $result->homeovertimescore;

					$homegamefinal = $homegamefinal + $result->homeovertimescore;			
					$awaygamefinal = $awaygamefinal + $result->awayovertimescore;
					$usethisheading = "<div class ='eachgame'><div class = 'eachgamel'><div class ='date'>".date('F d, Y', (strtotime($result->date)))."</div><div class ='spreadclass'>Spread: ".$result->minusteam ." " .$result->minusteamspread."</div><div class ='spreadclassOU'>Over/Under: ".$result->overunder."</div></div><div class ='eachgamer'><div id ='spreadresult'>O/U Result: ".$result->ouresult ."</div><div class ='mainspreadresult'>Favored team covered: ".$coveranswer. "</div></div>".$tableheading2;
					$otresulthome = "<td>".$result->homeovertimescore."</td>";
					$otresultaway = "<td>".$result->awayovertimescore."</td>";
				}
			else
			{
				$usethisheading = "<div class ='eachgame'><div class = 'eachgamel'><div class ='date'>".date('F d, Y', (strtotime($result->date)))."</div>". "<div class ='spreadclass'>Spread: ".$result->minusteam ." " .$result->minusteamspread."</div><div class ='spreadclassOU'>Over/Under: ".$result->overunder."</div></div><div class ='eachgamer'><div id ='spreadresult'>O/U Result: ".$result->ouresult ."</div><div class ='mainspreadresult'>Favored team covered: ".$coveranswer. "</div></div>".$tableheading1;
				$otresulthome = " ";
				$otresultaway = " ";
			}

			$usethisheading .= "<tbody>".$table4."<td class ='hometeamcell'>".$result->hometeam."</td><td>".$result->home1stqscore. "</td><td>" .$result->home2ndqscore."</td><td>". $result->home3rdqscore . "</td><td>" .$result->home4thqscore."</td>".$otresulthome."<td><b>".$homegamefinal."</b></td></tr>";
			$usethisheading .= $table7."<td class ='awayteamcell'>".$result->awayteam."</td><td>".$result->away1stqscore."</td><td>".$result->away2ndqscore."</td><td>". $result->away3rdqscore . "</td><td>" .$result->away4thqscore."</td>".$otresultaway."<td><b>".$awaygamefinal."</b></td></tr></tbody></table></div>";
		
				

			$allgameresults .= $usethisheading;
			

			if ($_POST['ddlteamchoice'] != "all")
			{
				if ($result->hometeam == $_POST['ddlteamchoice'])
				{
					if ($homegamefinal > $awaygamefinal)
						$won++;
				}
				else
					if ($awaygamefinal > $homegamefinal)
						$won++;
			}

		}

		if ($gamecount != 0)
		{

				$summtable = "<div id ='summary'><h2>Games Summary</h2><div id ='summtable'><table id ='quicksummtable'>";

				if ($_POST['ddlteamchoice'] != 'all')
				{
					$summtable .= "<tr>The ".$_POST['ddlteamchoice']." won ".$won."/".$gamecount." times</tr>";	
				}
				
			$summtable .= "<tr><td>Average Total Game Points Scored: </td><td>" . number_format(($total1stQH +$total2ndQH +$total3rdQH +$total4thQH +$total1stQA +$total2ndQA +$total3rdQA +$total4thQA + $totalOTA + $totalOTA)/$gamecount, 1). "</td></tr>";
			$summtable .= "<tr><td>Average 1st Qtr Points Scored: </td><td>" . number_format(($total1stQH +$total1stQA)/$gamecount, 1). "</td></tr>";
			$summtable .= "<tr><td>Average 2nd Qtr Points Scored: </td><td>" . number_format(($total2ndQH +$total2ndQA)/$gamecount, 1). "</td></tr>";
			$summtable .= "<tr><td>Average 3rd Qtr Points Scored: </td><td>" . number_format(($total3rdQH +$total3rdQA)/$gamecount, 1). "</td></tr>";
			$summtable .= "<tr><td>Average 4th Qtr Points Scored: </td><td>" . number_format(($total4thQH +$total4thQA)/$gamecount, 1). "</td></tr>";
			$summtable .= "<tr><td>Average First Half Points Scored: </td><td>".  number_format(($total1stQH +$total2ndQH +$total1stQA +$total2ndQA)/$gamecount, 1). "</td></tr>";
			$summtable .= "<tr><td>Average Second Half Points Scored: </td><td>".  number_format(($total3rdQH +$total4thQH +$total3rdQA +$total4thQA)/$gamecount, 1). "</td></tr>";
			$summtable .= "</table></div>";

		

			$vegassumtable = "<div id ='vegsummary'><h2>Vegas Line Summary</h2></div><div id ='vegassummtable'><table id = 'vegastable'>";
			$opercent = number_format(($overresult/$gamecount) * 100,1);
			$vegassumtable .= "<tr><td>Games went <span class ='yellowit'>OVER</span> <b class = 'special'>" . $opercent . "% </b>(" . $overresult . "/" . $gamecount . ") of the time</tr></td>" ;
			$upercent = number_format(($underresult/$gamecount) * 100,1);
			$vegassumtable .= "<tr><td>Games went <span class ='yellowit'>UNDER</span> <b class = 'special'>" .$upercent . "% </b>(" . $underresult . "/" . $gamecount . ") of the time</tr></td>" ;


			$teamsumtable = "";

			if ($_POST['ddlteamchoice'] == 'all' AND $_POST['against'] == 'all')
				{
				$favcov =  number_format(($favteamcov/$gamecount) * 100,1);
				$vegassumtable .= "<tr><td>Favored team <i>covered</i><b class = 'special'> " .$favcov . "% </b>(" . $favteamcov . "/" . $gamecount . ") of the time.</tr></td>" ;

				$undercov =  number_format(($underdogcov/$gamecount) * 100,1);
				$vegassumtable .= "<tr><td>Underdog team <i>covered</i><b class = 'special'> " .$undercov . "%</b> (" . $underdogcov . "/" . $gamecount . ") of the time.</tr></td>" ;
				}
			else 
			{
				if ($_POST['ddlteamchoice'] != 'all')
				{
					if ($teamisminusgames == 0)
						$minuscov = 0;
					else
						$minuscov = number_format(($pickedteamminuscover/$teamisminusgames) * 100,1);
					if ($teamisplusgames == 0)
						$pluscov = 0;
					else
						$pluscov = number_format(($pickedteampluscover/$teamisplusgames) * 100,1);

				
				$teamsumtable .= "<h2>Team Summary</h2><table><tr><td>Average <b>p</b>oints <b>p</b>er <b>g</b>ame: </td><td>".number_format(($pickedteamtotalpts/$gamecount) ,1) . "</td></tr>";
				$teamsumtable .= "<tr><td>Average 1st Q ppg: </td><td>".number_format(($pickedavg1q/$gamecount),1). "</td></tr>";
				$teamsumtable .= "<tr><td>Average 2nd Q ppg: </td><td>".number_format(($pickedavg2q/$gamecount) ,1). "</td></tr>";
				$teamsumtable .= "<tr><td>Average 3rd Q ppg: </td><td>".number_format(($pickedavg3q/$gamecount) ,1). "</td></tr>";
				$teamsumtable .= "<tr><td>Average 4th Q ppg: </td><td>".number_format(($pickedavg4q/$gamecount),1). "</td></tr>";
				$teamsumtable .= "<tr><td>Average 1st Half ppg: </td><td>".number_format((($pickedavg1q+ $pickedavg2q)/$gamecount) ,1). "</td></tr>";
				$teamsumtable .= "<tr><td>Average 2nd Half ppg: </td><td>".number_format((($pickedavg3q+ $pickedavg4q)/$gamecount) ,1). "</td></tr></table>";


				
				$vegassumtable .= "<tr><td>The ".$_POST['ddlteamchoice']." <i>covered</i><b class = 'special'> " .$minuscov . "% </b>(" . $pickedteamminuscover . "/" . $teamisminusgames . ") when they were <span class ='yellowit'>favored</span>.</tr></td>" ;
				
				$vegassumtable .= "<tr><td>The ".$_POST['ddlteamchoice']." <i>covered</i><b class = 'special'> " .$pluscov . "% </b>(" . $pickedteampluscover . "/" . $teamisplusgames . ") when they were <span class ='yellowit'>underdogs</span>.</tr></td>" ;
				}

				if ($_POST['against'] != 'all')
				{
					if ($againstisminusgames == 0)
						$minuscov2 = 0;
					else
						$minuscov2 = number_format(($againstteamminuscover/$againstisminusgames) * 100,1);
					if ($againstplusgames == 0)
						$pluscov2 = 0;
					else
						$pluscov2 = number_format(($againstteampluscover/$againstplusgames) * 100,1);

			
				$vegassumtable .= "<tr><td>The ".$_POST['against']." <i>covered</i><b class = 'special'> " .$minuscov2 . "% </b>(" . $againstteamminuscover . "/" . $againstisminusgames . ") when they were <span class ='yellowit'>favored</span>.</tr></td>" ;
				
				$vegassumtable .= "<tr><td>The ".$_POST['against']." <i>covered</i><b class = 'special'> " .$pluscov2 . "% </b>(" . $againstteampluscover . "/" . $againstplusgames . ") when they were <span class ='yellowit'>underdogs</span>.</tr></td>" ;
				}




				}

				if ($_POST['ddlteamchoice'] == 'all' and $_POST['homeoraway'] != 'both')
				{
					if ($_POST['homeoraway'] == 'Home')
					{

						if ($hometeamplusgames == 0)
							$hometeampluspercent = 0;
						else
							$hometeampluspercent = number_format(($hometeamcov/$hometeamplusgames) * 100,1);
						if ($hometeamminusgames == 0)
							$hometeamminuspercent = 0;
						else
							$hometeamminuspercent = number_format(($hometeamminuscov/$hometeamminusgames) * 100,1);

						if ($_POST['spread'] <= 0)
						{
						$vegassumtable .= "<tr><td>The Home team <i>covered</i><b class = 'special'> " .$hometeamminuspercent . "% </b>(" . $hometeamminuscov . "/" . $hometeamminusgames . ") when they were favored. </tr></td>";
						}
						if ($_POST['spread'] >= 0)
						{
						$vegassumtable .= "<tr><td>The Home team <i>covered</i><b class = 'special'> " .$hometeampluspercent . "% </b>(" . $hometeamcov . "/" . $hometeamplusgames . ") when they were underdogs. </tr></td>";
						}
						
					}
					else
					{

						if ($awayteamplusgames == 0)
							$awayteampluspercent = 0;
						else
							$awayteampluspercent = number_format(($awayteamcov/$awayteamplusgames) * 100,1);
						if ($awayteamminusgames == 0)
							$awayteamminuspercent = 0;
						else
							$awayteamminuspercent = number_format(($awayteamminuscov/$awayteamminusgames) * 100,1);

						$vegassumtable .= "<tr><td>The Away team <i>covered</i><b class = 'special'> " .$awayteamminuspercent . "% </b>(" . $awayteamminuscov . "/" . $awayteamminusgames . ") when they were favored. </tr></td>";
						$vegassumtable .= "<tr><td>The Away team <i>covered</i><b class = 'special'> " .$awayteampluspercent . "% </b>(" . $awayteamcov . "/" . $awayteamplusgames . ") when they were underdogs. </tr></td>";
					}



			}





		}

		if ($_POST['ddlteamchoice'] != 'all')
		{
			$mainjsondata['intro']= "<h3 class ='team'>".$_POST['ddlteamchoice']."</h3><p>Under chosen conditions, out of ".$gamecount." games: </p>";
		}
		else
		{
			$mainjsondata['intro']= "<p>Under chosen conditions, out of ".$gamecount." games: </p>";
		}
		$mainjsondata['allgames'] = $allgameresults;
		$mainjsondata['quicksum'] = $summtable;

		$vegassumtable .= "</table>";
		$mainjsondata['vegassum'] = $vegassumtable;
		$mainjsondata['teamsum'] = $teamsumtable;
		echo json_encode($mainjsondata);
	
		// $l = 1;
		// foreach($results as $result)
		// {
		// 	 echo $result->id . " - " . $l;
		// 	 echo "<br/>";
		// 	$l++;
		// }
	
	}
	
	
	
	}
	
	
	public function teamtable($arrofarr)
	{


	}
	
	
	
	
	//now are the parts that are in the conditions, the WHERE part of sql
			
			// if ($_POST['option9'] == 'nospread')
			// {
			// $run9 = "";
			// $run10 = "";
			// }
			// else
			// {
				// if (strpos($_POST['spread'], '.'))
						// $gamespread = $_POST['spread'];
						// else
						// $gamespread = $_POST['spread'] . ".0";
						
				// if (strpos($_POST['totalpointspread'], '.'))
						// $totalpointspread = $_POST['totalpointspread'];
						// else
						// $totalpointspread = $_POST['totalpointspread'] . ".0";	
						
						
				// $lookforspread  = ($_POST['against'] == 'all') ? "" : $_POST['against'];
				
				// if ($_POST['spread'] > 0)
				// {
					
					
					// $run9 = "(gamespread LIKE '%" . $lookforspread . "-".$gamespread."%')";
					
						// var_dump($run9);
					// die();
					
					
				// }
				// else if ($_POST['spread'] < 0)
				// {
				
						// $run9 = "((hometeam ==".$lookforspread." AND (gamespread LIKE '%" . $lookforspread . $gamespread."%')) OR ((awayteam ==".$lookforspread." AND (gamespread LIKE '%" . $lookforspread . $gamespread."%'))) )";
				
						// var_dump($run9);
					// die();
					
				
				// }
				// else
				// {}
			
			
			// }
		
	
	
	
		// if ($_POST['option13'] == 'all')
					// {
						// $run10 = ""
					// }
					// else
					// {
						
						// switch ($_POST['whatday'])
						// {
							// case "Thursday":
								// $run10 = "AND (date LIKE '%-09-%')";
								// break;
							// case "Saturday":
								// $run10 = "AND (date LIKE '%-11-%')";
								// break;
							// case "Sunday":
								// $run10 = "AND (date LIKE '%-12-%')";
								// break;
							// case "Monday":
								// $run10 = "AND (date LIKE '%-01-%')";
								// break;			
						// }
					
					// }
					
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */