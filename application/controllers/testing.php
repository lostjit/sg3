<!doctype HTML>



<html>
	<head>
		<title>Green Belt Test</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

		
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
			<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
			<link rel="stylesheet" type="text/css" href="style.css" />
			<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css" media="all" />
			<script type ="text/javascript">  
				
				$(document).ready(function(){
				
						
				});		
			</script>
		
	</head>
	
	<body>
		<div id="wrapper">
		
		
		
	 <?php

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
			
			
		?>
				
			<?php
			// Defining the basic scraping function
			function scrape_between($data, $start, $end){
			$data = stristr($data, $start); // Stripping all data from before $start
			$data = substr($data, strlen($start));  // Stripping $start
			$stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
			$data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
			return $data;   // Returning the scraped data from the function
			}
			?>	
				
				
				
				<?php
				
			function ultimate()
     
			{
				$url = "http://www.pro-football-reference.com/boxscores/200312280nor.htm";    // Assigning the URL we want to scrape to the variable $url
				
				$results_page = curl($url); // Downloading the results page using our curl() funtion		
	 
				$results_page = scrape_between($results_page, "<table class=\"stats_table x_large_text\" data-freeze=\"1\" id=\"linescore\">", "<div class=\"table_container\" id=\"div_def_stats\">"); // Scraping out only the middle section of the results page that contains our results		
				 
				 $separate_results = explode("<td", $results_page);   // Exploding the results into separate parts into an array
				
					$html = "";
				 foreach($separate_results as $results)
				 {
							
							//echo $results;
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
					
					// for ($i = 0; $i < count($newtemp); $i++)
					// {
						// echo "(" . $i . ")" ." " . $newtemp[$i];
						// echo "<br/>";
					
					// }
					
					return $newtemp;
					
					//die();
			 
			 }
			 
			 
			 
			 
			 
			 function ultra($arr)
			 {
				$stuffcsv = "";
					for ($i = 0; $i < count($arr); $i++)
					{
						if (($i == 1) or ($i == 7))	
						{
							$stuffcsv .= $arr[$i] . ",";						
						}
						else if (($i == 2) or ($i == 3)  or ($i == 4)  or ($i == 5)  or ($i == 8)  or ($i == 9)  or ($i == 10)  or ($i == 11))	
						{
							$stuffcsv .= $arr[$i] . ",";						
						}
						
						else if ($arr[$i] == 'Over/Under')
						{
							$stuffcsv .= $arr[($i+1)] . ",";	
						}
						else if ($arr[$i] == 'Stadium')
						{
							$stuffcsv .= $arr[($i+1)] . ",";	
						}
						else if ($arr[$i] == 'Turnovers')
						{
							$stuffcsv .= $arr[($i+1)] . ",";
							$stuffcsv .= $arr[($i+2)] . ",";
						}
						else if ($arr[$i] == 'Start Time')
						{
							$stuffcsv .= $arr[($i+1)] . ",";	
						}
						else if ($arr[$i] == 'Weather')
						{
							while($arr[$i] != 'Vegas Line')
							{
								$stuffcsv .= $arr[($i+1)] . " ";
									$i++;
							}
							
							$stuffcsv .= ",";
							
							if ($arr[$i] == 'Vegas Line')
							{
							$stuffcsv .= $arr[($i+1)] . ",";	
							}
						}
						else if ($arr[$i] == 'Referee')
						{
							$stuffcsv .= $arr[($i+1)] . ",";	
						}										
					}			 
					
					echo($stuffcsv);
						die();	
			 }
			 
			$temp =  ultimate();
			ultra($temp);
			
			 
			 
			// $separate_results = explode("<td class=\"image\">", $results_page);   // Exploding the results into separate parts into an array
			 
			//For each separate result, scrape the URL
			// foreach ($separate_results as $separate_result) {
				// if ($separate_result != "") {
					// $results_urls[] = "http://www.imdb.com" . scrape_between($separate_result, "href=\"", "\" title="); // Scraping the page ID number and appending to the IMDb URL - Adding this URL to our URL array
				// }
			// }
     
        
 
        	
				// ?>
			
			
		
		
		
			
		</div>

	</body>
</html>


<?php session_unset() ?>