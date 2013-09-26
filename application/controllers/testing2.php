<?php 

ini_set('MAX_EXECUTION_TIME', -1);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class testing2 extends CI_Controller 
{	
	public $arrplayers = array();
	public $playerid;

		public function __construct()
		{


			parent::__construct();	
			$this->arrplayers = $this->getallplayers();
			$this->playerid = 0;
			
		}
		
		
		
	 
			 function curl($url) {
        // Assigning cURL options to an array
        $options = Array(
            CURLOPT_RETURNTRANSFER => TRUE,  // Setting cURL's option to return the webpage data
            CURLOPT_FOLLOWLOCATION => TRUE,  // Setting cURL to follow 'location' HTTP headers
            CURLOPT_AUTOREFERER => TRUE, // Automatically set the referer where following 'location' HTTP headers
            CURLOPT_CONNECTTIMEOUT => 120,   // Setting the amount of time (in seconds) before the request times out
            CURLOPT_TIMEOUT => 120,  // Setting the maximum amount of time for cURL to execute queries
            CURLOPT_MAXREDIRS => 10, // Setting the maximum number of redirections to follow
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8",  // Setting the useragent
            CURLOPT_URL => $url, // Setting cURL's URL option with the $url variable passed into the function
			);
         
			$ch = curl_init();  // Initialising cURL 
			curl_setopt_array($ch, $options);   // Setting cURL's options using the previously assigned array data in $options
			$data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
			curl_close($ch);    // Closing cURL 
			return $data;   // Returning the data from the function 
			}
			
			
		
				
		
			// Defining the basic scraping function
			function scrape_between($data, $start, $end){
			$data = stristr($data, $start); // Stripping all data from before $start
			$data = substr($data, strlen($start));  // Stripping $start
			$stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
			$data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
			return $data;   // Returning the scraped data from the function
			}
			

			function ultimate($sitetogoto)
     
			{




				$url = "http://www.pro-football-reference.com/boxscores/" . $sitetogoto;    // Assigning the URL we want to scrape to the variable $url
				
				$results_page = $this->curl($url); // Downloading the results page using our curl() funtion		
	 
				$results_page = $this->scrape_between($results_page, "<div class=\"float_left margin_right\">", "<div class=\"table_container\" id=\"div_def_stats\">"); // Scraping out only the middle section of the results page that contains our results		
				 



				 $separate_results = explode("<td", $results_page);   // Exploding the results into separate parts into an array
				$storeit = $separate_results[0];


				$html = "";
				 foreach($separate_results as $results)
				 {
							
							
							preg_match("/>(.*)</", $results, $test) ;
							
							$html .= $test[1] . ",";
							
				 }
				 
				 
				 for ($i = 0; $i < strlen($html); $i++)
				 {
				 
					if ($html[$i] == '<')
					{
						
						
						for($k = $i; $html[$k] != '>'; $k++)
						{
							$html[$k] = " ";					
						}
						
						$i = $k;
						if ($html[$i] == ">")
						{
							$html[$i] = " ";
						}
					
					}
						 
				 }
				 

				 
					$html = preg_replace('/\s\s+/', '', $html);	
					
					
					$newtemp = explode(",", $html);	



					$storeit = str_split($storeit);
					$meh2 = "";
					for($i = 0; $i < count($storeit); $i++)
					{					
						if ($storeit[$i] == "<")
						break;	
						$meh2 .= $storeit[$i];
					}

					$storeit = $meh2;
					preg_match("/day, (.*)/", $storeit, $results);
					$storeit = $results[1];
					
					$storeit = date('Y-m-d', strtotime($storeit));
					$newtemp[0] = $storeit;

					
					
	

					 return $newtemp; //returns cleaned up array
					
					
			 
			 } 
				
			function ultimate2($mainsite)
     
			{
				$url = $mainsite;    // Assigning the URL we want to scrape to the variable $url				
				$results_page = $this->curl($url); // Downloading the results page using our curl() funtion 
				$results_page = $this->scrape_between($results_page, "<tbody>", "<strong>Playoffs</strong>"); // Scraping out only the middle section of the results page that contains our results					
				$separate_results = explode("<a", $results_page);				
				$html = "";
				$poop = array();				
				 foreach($separate_results as $results)
				 {		
							preg_match('+boxscores(.*)+', $results, $test);							
							if (count($test) > 0)
							{
								$poop[] = $test[1];						
							}													
				 }
				 
				 for ($i = 0; $i < count($poop); $i++)
				 {				 
					$poop[$i] = substr($poop[$i], 0, 17);						 
				 }				 
				return $poop;			 
			 }
			 

			 function ultra($arr, $gameid)
			{
				$csvfile =  $gameid . "," . $arr[0] . ",";
				//$csvplayerfile = $gameid . ",";
				$csvfile .= $arr[1] . "," . $arr[2] . "," . $arr[3] . ",".$arr[4] . ",".$arr[5] . ",".$arr[7] . ",".$arr[8]. ",".$arr[9]. ",".$arr[10]. ",".$arr[11] . ",";
				
				

				for ($i = 12; $i < count($arr); $i++)
				{
					//this section is for the game table data

						if ($arr[$i] == "Weather")
						{
							while($arr[$i] != "Referee")
							{
								$csvfile .= $arr[($i+1)];
								$i++;
							}
							$csvfile .= ",";
						}

						if (($arr[$i] == "Stadium") OR ($arr[$i] == "Start Time") OR ($arr[$i] == "Surface") OR ($arr[$i] == "Referee") OR ($arr[$i] == "Vegas Line") OR ($arr[$i] == "Over/Under"))
						{

							$csvfile .= $arr[($i+1)] . ",";

						}

						if ($arr[$i] == "Turnovers")
						{
							
								$csvfile .= $arr[($i+1)] . ",";
								$csvfile .= $arr[($i+2)];		
						}


					//now we get the "game has player" table data

						
						
						if ($this->iscurrentPlayer($arr[$i]))
						{
						

							$csvplayerfile = $gameid . "," . $this->playerid . ",";
							
														
							for($k = ($i + 2); $k < ($i +15); $k++)
							{
								$meh = $this->ifnull($arr[$k]);
									
								$meh = $this->ifnull($arr[$k]);

								$csvplayerfile .= $meh . ",";

							}
							$meh = $this->ifnull($arr[($i +15)]);
							$csvplayerfile .= $meh . "\xA";

							$f = fopen("2012playerstats.txt", "a"); 
							fwrite($f, $csvplayerfile . "\xA");
								fclose($f); 

							$i = $i + 14;

						}

						



				}

				//echo $csvplayerfile;
				// $almostdone = $this->cleanup($csvfile);
				// 	$f = fopen("2012gamestats.txt", "a");					
				// 	for ($i = 0; $i < count($almostdone); $i++)
				// 	{
						
				// 		if (($i+1) == count($almostdone))
				// 			fwrite($f, $almostdone[$i] . "\xA");
				// 		else
				// 			fwrite($f, $almostdone[$i] . ",");					
				// 	}
				// 	fclose($f); 


			}

			function ifnull($argue)
			{
				
				if ($argue == "")				
					return '0';
				else 
					return $argue;

			}

	
			function getallplayers()
			{

				$this->load->model("statgrabPlayers");
				return $this->statgrabPlayers->getallplayers()->result();

			}


			function iscurrentPlayer($indexofArr)
			{
				
				$result = false;
				
				for ($i = 0; $i < count($this->arrplayers); $i++)
				{
					if ($indexofArr == $this->arrplayers[$i]->fullname)
					{
						$this->playerid = $this->arrplayers[$i]->id;
						return true;						
					}					
				}
				return $result;

			}


			function cleanup($somestring)
			{
				
				
				$somearray = explode(",", $somestring);
				
			

				$newword = str_split($somearray[2]);
				
				
				$meh = "";
				for($i = 0; $i < count($newword); $i++)
				{					
					if ($newword[$i] == "(")
					break;	
					$meh .= $newword[$i];
				}
				$somearray[2] = $meh;
			

				$newword = str_split($somearray[7]);	
				$meh = "";
				for($i = 0; $i < count($newword); $i++)
				{					
					if ($newword[$i] == "(")
					break;	
					$meh .= $newword[$i];
				}
				$somearray[7] = $meh;

				$newword = str_split($somearray[15]);	
				$meh = "";
				for($i = 0; $i < count($newword); $i++)
				{					
					if ($newword[$i] == "R")
					break;	
					$meh .= $newword[$i];
				}

				$somearray[15] = $meh;

	

				// $newword = str_split($somearray[17]);	
				// $meh = "";
				// for($i = 0; $i < count($newword); $i++)
				// {					
					// if ($newword[$i] == "(")
					// break;	
					// $meh .= $newword[$i];
				// }

				// $somearray[17] = $meh;

				// $newword = str_split($somearray[15]);	
				// $meh = "";
				// for($i = 0; $i < count($newword); $i++)
				// {					
				// 	if ($newword[$i] == "-" or is_numeric($newword[$i]) or $newword[$i] == ".")	
				// 	$meh .= $newword[$i];
				// }

				// $somearray[15] = $meh;

				echo "<pre>";
				var_dump($somearray);
				echo "</pre>";
				die();
				
				return $somearray; //array with trimmed down information that needs to be put in csv
			}



			function putitin($arrofgames)
			{

				$giantarr = array();
				for($i = 0; $i < count($arrofgames); $i++)
				{

					$giantarr[] = $this->ultimate($arrofgames[$i]);

				}

				return $giantarr;
			}
}
			
			set_time_limit(1800);

			
			
			$meh = new testing2();


				//get team record also, put in OVERTIME, check for WEATHER.
			
			//$meh->ultra($meh->ultimate("200309140tam.htm"), 1);

			$arrGames = $meh->ultimate2("http://www.pro-football-reference.com/years/2012/games.htm");
			$mainArray = $meh->putitin($arrGames);

			$gameid = 2306;
			foreach($mainArray as $game)

			{
				$meh->ultra($game, $gameid);
				$gameid++;
			}
			
			echo "DONE";

			
			die();

			
			

		
	
			 
			 
			



















			?>
			
			
		
		
	