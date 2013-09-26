<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link href="http://fonts.googleapis.com/css?family=Corben:bold" rel="stylesheet" type="text/css">
	<?php //require("/assets/includes/header.php")?>	
	<?php require($_SERVER['DOCUMENT_ROOT']."/assets/includes/header.php")?>
	<title>Sports Stat Grab</title>
		
		
	
			<script type ="text/javascript">  
				
				$(document).ready(function(){
				

						$("#teamheaders").hide();

						$("#resultsarea").hide();
						$("#showtrail :input").attr("disabled", true);
						$("#yesspread :input").attr("disabled", true);
						$("#pickday :input").attr("disabled", true);
						$("#showextra :input").attr("disabled", true);						
						$("#pickstats :input").attr("disabled", true);
						$("#teamsshowtrail :input").attr("disabled", true);
						$("#teamsshowextra :input").attr("disabled", true);						
						$("#teamspickstats :input").attr("disabled", true);		

						$("#teamstatdiv").show();			
						
						glow1();
						glow2();
					
					
						function glow1()
						{
							setInterval(function(){$("#specialeditor").animate({color: "#76EE00"}, 600)}, 2400);
						}

						function glow2()
						{
							setInterval(function(){$("#specialeditor").animate({color: "white"}, 600)}, 2400);
						}

						$(document).on('change', '#teamchoice', function (){

							
							bleh = $("#teamchoice").val();
							$(".chosenteam").html("");
							$(".chosenteam").html(bleh);
						});

					





				
						$(document).on('submit', '#mainform', function (){
								$.post(
									$(this).attr('action'), 
									$(this).serialize(),
									function(data1){


										$("#vegassumteam").hide();
										$("#quicksumteam").hide();
										$("#teamresults").hide();
										$("#teamheaders").hide();
										 $("#teamintro").hide();
										 $("#resultsarea").show();
										 $("#averagediv").show();
										 $("#indivresults").show();
										 $("#averagediv").val("");
										 $("#indivresults").val("");
										 $("#averagediv").html(data1.averages);
										 $("#indivresults").html(data1.gamestats);
										  $('html, body').animate({

										 	scrollTop: $("#resultsarea").offset().top
										 }, 2000);


									},
										"json"
								); 											
							return false;									
						});
						

						$(document).on('submit', '#teamform', function (){
								$.post(
									$(this).attr('action'), 
									$(this).serialize(),
									function(data1){
										$("#averagediv").val("");
										 $("#indivresults").val("");
										  $("#vegassumteam").val("");
										 $("#quicksumteam").val("");
										 $("#teamresults").val("");
										 $("#teamintro").val("");
										 $("#vegassumteam").show();
										$("#quicksumteam").show();
										$("#teamresults").show();
										$("#teamheaders").show();
										 $("#resultsarea").show();
										 $("#teamintro").show();
										 $("#averagediv").hide();
										 $("#indivresults").hide();
										 $("#vegassumteam").html(data1.vegassum);
										 $("#quicksumteam").html(data1.quicksum);
										 $("#teamresults").html(data1.allgames);
										 $("#teamintro").html(data1.intro);
										 $("#teamsum").html(data1.teamsum);

										 if ($('#teamsum').children().length >= 1)
										 {
											 $("#teamsum").show();
											}	
											else
											$("#teamsum").hide();

											$('html, body').animate({

										 	scrollTop: $("#resultsarea").offset().top
										 }, 1100);


									},
										"json"
								); 		


													
							return false;	

						});
						
						
						//individual stats javascript
						$(document).on('click', "#individual", function (){
								
								
									$("#individualdiv").show();
									$("#teamstatdiv").hide();
									
									
									$("#teamsresetindiv").click();
									$("#teamsshowtrail").hide();
									$("#teamsyesspread").hide();
									$("#teamspickday").hide();
									$("#teamsshowextra").hide();						
									$("#teamspickstats").hide();
									
									$(".chosenteam").html("all teams");
									return false;
									
								

						});		
						
						
						
						
						$(document).on('click', "#trailorahead", function (){
								
								
									if(!$("#notrail").is(':checked'))
									{	
											$("#showtrail").show();	
											$("#showtrail :input").attr("disabled", false);
										
									}
									else
									{	
										$("#showtrail :input").attr("disabled", true);
										$("#showtrail").hide();
										
									}	
						

						});					
								
						$(document).on('click', "#spreadorno", function (){
								
								
									if(!$("#rdNoSpread").is(':checked'))
									{	
											$("#yesspread").show();	
												$("#yesspread :input").attr("disabled", false);
										
									}
									else
									{	
										$("#yesspread :input").attr("disabled", true);
										$("#yesspread").hide();
									}	
						

						});	

					$(document).on('click', "#whatdayorno", function (){
								
								
									if(!$("#yesday").is(':checked'))
									{	
											$("#pickday :input").attr("disabled", false);
											$("#pickday").show();									
										
									}
									else
									{	
										$("#pickday :input").attr("disabled", true);
										$("#pickday").hide();
									}	
						

						});		

						$(document).on('click', "#extraconditions", function (){
								
								
									if(!$("#noextra").is(':checked'))
									{	
											$("#showextra :input").attr("disabled", false);
											$("#showextra").show();									
										
									}
									else
									{		
										$("#showextra :input").attr("disabled", true);
										$("#showextra").hide();
										
									}	
						

						});	
						
						$(document).on('click', "#whichstats", function (){
								
								
									if($("#allstats").is(':checked'))
									{	
											$("#pickstats :input").attr("disabled", false);
											$("#pickstats").show();									
										
									}
									else
									{		
										$("#pickstats :input").attr("disabled", true);
										$("#pickstats").hide();
										
									}	
						

						});	
						
							
						//team stats javascript

							$(document).on('click', "#teams", function (){
								
								
									$("#teamstatdiv").show();
									$("#individualdiv").hide();
									$("#resetindiv").click();
									$("#showtrail").hide();
									$("#yesspread").hide();

										$("#teamswhatpartofgame").hide();
								
									$("#teamspickday").show();
									$("#showextra").hide();						
									$("#pickstats").hide();
									
									
									return false;

								});	
								
								
								
						
						
						
						
							
						
						$(document).on('click', "#teamstrailorahead", function (){
								
								
									if(!$("#teamsnotrail").is(':checked'))
									{	
											$("#teamsshowtrail").show();	
											$("#teamsshowtrail :input").attr("disabled", false);
										
									}
									else
									{	
										$("#teamsshowtrail :input").attr("disabled", true);
										$("#teamsshowtrail").hide();
										
									}	
						

						});					
								
						$(document).on('click', "#teamsspreadorno", function (){
								
								
									if(!$("#teamsrdNoSpread").is(':checked'))
									{	
											$("#teamsyesspread").show();	
												//$("#teamsyesspread :input").attr("disabled", false);
										
									}
									else
									{	
										//$("#teamsyesspread :input").attr("disabled", true);
										$("#teamsyesspread").hide();
									}	
						

						});	

			

				
						$(document).on('click', "#teamsextraconditions", function (){
								
								
									if(!$("#teamsnoextra").is(':checked'))
									{	
											$("#teamsshowextra :input").attr("disabled", false);
											$("#teamsshowextra").show();									
										
									}
									else
									{		
										$("#teamsshowextra :input").attr("disabled", true);
										$("#teamsshowextra").hide();
										
									}	
						

						});	
						



						$(document).on('click', "#teamswhichstats", function (){
								
								
									if($("#teamsallstats").is(':checked'))
									{	
											$("#teamspickstats :input").attr("disabled", false);
											$("#teamspickstats").show();									
										
									}
									else
									{		
										$("#teamspickstats :input").attr("disabled", true);
										$("#teamspickstats").hide();
										
									}	
						

						});		
								
					
							
				
								
								
								
								
								
								
								
								
								
								
						
						
						});	
						
						
						
					
			</script>
	

</head>
<body>


<div id="wrapper">

	<div id ='toppart'>
		<h1>Sports Stat Grab!</h1>
		<div id ='editornote'>
			
				<a href='#myModal' role='button' data-toggle='modal'><div id ='specialeditor'>Editor's Note</div></a>

				<div id='myModal' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
					  <div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
						<h3 id='myModalLabel'>Editor's Note</h3>
					  </div>
					  <div class='modal-body'>
						<p>Welcome, our dear guest, to Sports Stat Grab.  This site is made for you to query various sports stats.  For now, we only have NFL stats but rest assured we are working on getting more sport stats on here.  Please look around in our <a href="/welcome/faq">FAQ</a> section if you have questions and feel free to send us any feedback or suggestions.  We're going to grow and bring you the best possible experience!</p>

						<p>Thank you,</p>
						 Sports Stat Grab
					  </div>
					  <div class='modal-footer'>
						<button  data-dismiss='modal' aria-hidden='true'>Close</button>
						
					  </div>
					</div>









		</div>
		<div id = 'menubar'>
		<a class ='faq' href ="http://www.ilikemilktea.com">Home</a>
		 <a class ='faq' href="/welcome/faq">FAQ</a>
		 <a class ='faq' href="/welcome/contact">Contact</a>
		</div>
	</div>
	
	<div id ='middlecont'>
	
		<div id ='leftmid'>

			<div id ='majorselection'>
				
				<div id ='teamicon'>
				<a id = 'teams' href="">
				Team Stats
				</a>
				</div>
				<div id ='indivicon'>
				<a id ='individual' href="">
				Individual Stats
				</a>
				</div>
				
				
			</div>

		</div>
			
		<div id ='rightmid'>
			
		
		
				<div id = 'individualdiv'>
					<form id='mainform' method = 'post' action ='/welcome/whatstat' >
					<input type ='hidden' name='action' value ='indiv'>
						<div id = 'firstIndivDiv' class ='hideit'>
							<p>
							<?php			
								echo $players2;			
							?>
							</p>
						</div>	
						
						<div id ='whichstats'>
							<p>
								
								<button id ='resetindiv' type="reset" value="Reset"></button>
								
								<input  type ='radio' name ='allstats' value = 'all' checked ='checked'>All Stats<input id = 'allstats' type ='radio' name ='allstats' value = 'somestats'>Particular Stats
								
								<div id ='pickstats'>
									<input type ='checkbox' name ='option1' value = 'receptions'>Receptions
									<input type ='checkbox' name ='option2' value = 'receivingYards'>Receiving Yards
									<input type ='checkbox' name ='option3' value = 'passingyards'>Passing Yards
									<input type ='checkbox' name ='option4' value = 'rushingYards'>Rushing Yards
									<input type ='checkbox' name ='option5' value = 'receivingtouchdowns'>Receiving Touchdowns
									<input type ='checkbox' name ='option6' value = 'rushingtouchdowns'>Rushing Touchdowns
									<input type ='checkbox' name ='option7' value = 'passingtouchdowns'>Passing Touchdowns
									<input type ='checkbox' name ='option8' value = 'interceptions'>Interceptions
									
								</div>
							</p>
						</div>
						
					
						
						
						
						<div id ='against'>
							<p> Against: 				
								<?php 					
								echo "
								
								<select id ='against' name ='against'>
								<option value = 'all'>All Teams</option>
								<option>Arizona Cardinals</option>
								<option>Atlanta Falcons</option>
								<option>Baltimore Ravens</option>
								<option>Buffalo Bills</option>
								<option>Carolina Panthers</option>
								<option>Chicago Bears</option>
								<option>Cincinnati Bengals</option>
								<option>Cleveland Browns</option>
								<option>Dallas Cowboys</option>
								<option>Denver Broncos</option>
								<option>Detroit Lions</option>
								<option>Green Bay Packers</option>
								<option>Houston Texans</option>
								<option>Indianapolis Colts</option>
								<option>Jacksonville Jaguars</option>
								<option>Kansas City Chiefs</option>
								<option>Miami Dolphins</option>
								<option>Minnesota Vikings</option>
								<option>New England Patriots</option>
								<option>New Orleans Saints</option>
								<option>New York Giants</option>
								<option>New York Jets</option>
								<option>Oakland Raiders</option>
								<option>Philadelphia Eagles</option>
								<option>Pittsburgh Steelers</option>
								<option>San Diego Chargers</option>
								<option>San Francisco 49ers</option>
								<option>Seattle Seahawks</option>
								<option>St. Louis Rams</option>
								<option>Tampa Bay Buccaneers</option>
								<option>Tennessee Titans</option>
								<option>Washington Redskins</option>
								</select>";
								
								
								?>				
							</p>
						</div>

						
							
													
							
							<div id ='extraconditions'>
								<p> <input id = 'noextra' type ='radio' name ='noextra' value = 'noextra' checked='checked'>No extra conditions <input type ='radio' name ='noextra' value = 'yesextra'>Extra Conditions:	
							</div>
							
							<div id ='showextra'>
						
								<div id ='whatmonth'>
									<p> In month: 				
										<?php 								
										echo "
										<select id ='month' name ='month'>
											<option>All</option>
											<option>September</option>
											<option>October</option>
											<option>November</option>
											<option>December</option>
											<option>January</option>
										</select>
										";					
										?>				
									</p>
								</div>
									
							
								
								
								<div id ='timeofday'>
									<p> Time of day (EST): 				
										<?php 								
										echo "
										<select id ='timeofday' name ='timeofday'>
											<option>All Day</option>
											<option>Morning</option>
											<option>Afternoon</option>
											<option>Night</option>						
										</select>
										";					
										?>				
									</p>
								</div>
								
								
								
								
										
								
							</div>
						
						
						
							<input type ='submit' value ='Grab that Stat!'>
					
						</form>	
					</div><?php 
					
						//end of individual window
						//begin team one
					?>
					
					
					
					
					
					
					
			<div id ='teamstatdiv'>
				<div id ='topteamheader'>

					
				<form id='teamform' method = 'post' action ='/welcome/whatstat' >
				

					<p><span class ='floatleft'>Main choice:</span> 
				<?php 					
								echo "
								
								<select id ='teamchoice' name ='ddlteamchoice'>
								<option value = 'all'>All Teams</option>
								<option>Arizona Cardinals</option>
								<option>Atlanta Falcons</option>
								<option>Baltimore Ravens</option>
								<option>Buffalo Bills</option>
								<option>Carolina Panthers</option>
								<option>Chicago Bears</option>
								<option>Cincinnati Bengals</option>
								<option>Cleveland Browns</option>
								<option>Dallas Cowboys</option>
								<option>Denver Broncos</option>
								<option>Detroit Lions</option>
								<option>Green Bay Packers</option>
								<option>Houston Texans</option>
								<option>Indianapolis Colts</option>
								<option>Jacksonville Jaguars</option>
								<option>Kansas City Chiefs</option>
								<option>Miami Dolphins</option>
								<option>Minnesota Vikings</option>
								<option>New England Patriots</option>
								<option>New Orleans Saints</option>
								<option>New York Giants</option>
								<option>New York Jets</option>
								<option>Oakland Raiders</option>
								<option>Philadelphia Eagles</option>
								<option>Pittsburgh Steelers</option>
								<option>San Diego Chargers</option>
								<option>San Francisco 49ers</option>
								<option>Seattle Seahawks</option>
								<option>St. Louis Rams</option>
								<option>Tampa Bay Buccaneers</option>
								<option>Tennessee Titans</option>
								<option>Washington Redskins</option>
								</select>";								
								
				?>	
			</p>

					
							<p> <span class='floatleft'>Against: </span>				
								<?php 					
								echo "
								
								<select id ='against' name ='against'>
								<option value = 'all'>All Teams</option>
								<option>Arizona Cardinals</option>
								<option>Atlanta Falcons</option>
								<option>Baltimore Ravens</option>
								<option>Buffalo Bills</option>
								<option>Carolina Panthers</option>
								<option>Chicago Bears</option>
								<option>Cincinnati Bengals</option>
								<option>Cleveland Browns</option>
								<option>Dallas Cowboys</option>
								<option>Denver Broncos</option>
								<option>Detroit Lions</option>
								<option>Green Bay Packers</option>
								<option>Houston Texans</option>
								<option>Indianapolis Colts</option>
								<option>Jacksonville Jaguars</option>
								<option>Kansas City Chiefs</option>
								<option>Miami Dolphins</option>
								<option>Minnesota Vikings</option>
								<option>New England Patriots</option>
								<option>New Orleans Saints</option>
								<option>New York Giants</option>
								<option>New York Jets</option>
								<option>Oakland Raiders</option>
								<option>Philadelphia Eagles</option>
								<option>Pittsburgh Steelers</option>
								<option>San Diego Chargers</option>
								<option>San Francisco 49ers</option>
								<option>Seattle Seahawks</option>
								<option>St. Louis Rams</option>
								<option>Tampa Bay Buccaneers</option>
								<option>Tennessee Titans</option>
								<option>Washington Redskins</option>
								</select>";
								
								
								?>				
							</p>
					


					</div> 
			
					<div id ='teamswhichstats'>

								<button id ='teamsresetindiv' type="reset" value="Reset"></button>
							<!-- <p>
								
								
								<input  type ='radio' name ='allstats' value = 'all' checked ='checked'>All Stats<input id = 'teamsallstats' type ='radio' name ='allstats' value = 'somestats'>Particular Stats
								
								<div id ='teamspickstats'>
									<input type ='checkbox' name ='option1'>Win or Lose
									<input type ='checkbox' name ='option2'>Points Allowed
									<input type ='checkbox' name ='option3'>Points Scored
									
								</div>
							</p> -->
						</div>
						
						<div id = 'teamscondition'>
							
							<div id ='teamswhatpartofgame'>
								<p> Part of game?: 				
									
									<select id ='partofgameteam' name ='partofgame'>
										<option>Whole Game</option>
										<option>First Half</option>
										<option>Second Half</option>
										<option>1st Quarter</option>
										<option>2nd Quarter</option>
										<option>3rd Quarter</option>
										<option>4th Quarter</option>
										<option>Overtime</option>
									</select>
													
								</p>
							 </div>
							
							<p>While <span class ='chosenteam'>All Teams</span> are:
									<select id ='teamshomeoraway' name ='homeoraway'>
										<option value = 'both'>Home/Away</option>
										<option>Home</option>
										<option>Away</option>
									</select>
								</p>
							
							
							
							
							<!-- 	<p>
								<div id = 'teamstrailorahead'>
									<input id = 'teamsnotrail' type ='radio' name ='option10' value = 'all' checked ='checked'>All<input type ='radio' name ='option10' value = 'trailing'>While Trailing<input type ='radio' name ='option10' value = 'ahead'>While Ahead
								</div>
								
								<div id ='teamsshowtrail'>
									<?php //only show this by label when the All radio button is not active?>
									<label>(Going into 2nd half) by:</label><input type='number' name = 'trailorahead' min='0' max='50' step='1' value='0'>
								</div>
							
							</p> -->
							
							
						</div>
						
						
					

							<div id ='teamsspreadorno'>
								<p>					
									<input id ='teamsrdNoSpread' type ='radio' name ='option9' value = 'nospread' checked='checked'>No Spread	<input type ='radio' name ='option9' value = 'spread'>With Spread
								</p>
							</div>
							
							<div id ='teamsyesspread'>
								<p> <span class ='chosenteam'>Main Team </span> Game Spread: 										
									
									<select name ='spread'>

										<?php for($i = 25; $i > 0 ; $i-= .5)
										echo "<option value = '$i'>+$i</option>";

										?>
										<option value = 'All' selected = 'selected'>All</option>
										<?php for($i = -1; $i > -25.5 ; $i-= .5)
										echo "<option value = '$i'>$i</option>";

										?>
										
									</select>
								</p>
									<!-- <input type='number' name = 'spread' min='-25' max='25' step='.5' value='0'> -->
									
									
									<p>
									Over/Under
									<!-- <select name = 'comparison'>
										<option value = '$i'>=</option>
										<option value = '$i'>></option>
										<option value = '$i'><</option>
									</select> -->
									<select name ='totalspread'>
									<option value = 'all'>All</option>
									<?php for($i = 30; $i < 61; $i+= .5)
										echo "<option value = '$i'>$i</option>";

										?>
									</select>
													
									</p>
							</div>
							
													
							
							<div id ='teamsextraconditions'>
								<p> <input id = 'teamsnoextra' type ='radio' name ='noextra' value = 'noextra' checked='checked'>No extra conditions <input type ='radio' name ='noextra' value = 'yesextra'>Extra Conditions:	
							</div>
							
							<div id ='teamsshowextra'>
						
								<div id ='teamswhatmonth'>
									<p> In month: 				
										<?php 								
										echo "
										<select id ='month' name ='month'>
											<option>All</option>
											<option>September</option>
											<option>October</option>
											<option>November</option>
											<option>December</option>
											<option>January</option>
										</select>
										";					
										?>				
									</p>
								</div>
									
						
								
								<?php //only shows up when On day is checked?>
								<div id ='teamspickday'>
									<p>On day: 
									<select id ='teamswhatday' name ='whatday'>
										<option value = '0'>All</option>
										<option value = '5'>Thursday</option>
										<option value = '7'>Saturday</option>
										<option value = '1'>Sunday</option>	
										<option value = '2'>Monday</option>
									</select>
									</p>
								</div>	
								
								
								<div id ='teamstimeofday'>
									<p> Time of day (EST): 				
										<?php 								
										echo "
										<select id ='timeofday' name ='timeofday'>
											<option>All Day</option>
											<option>Morning</option>
											<option>Afternoon</option>
											<option>Night</option>						
										</select>
										";					
										?>				
									</p>
								</div>
								
								
								
							
										
								
							</div>
						
						
						
							<input type ='submit' value ='Grab that Stat!'>
					
						</form>	
					</div>							
		</div>


	</div><!--  end of middle container -->
	
	<div id ='thebottomhalf'>
		
		<div id ='resultsarea'>
			
			<div id='mainresultsindiv'>
				<div id ='averagediv'>
				</div>
				
				<div id ='indivresults'>			
				</div>
			</div>

			<div id = 'teamresultsmaindiv'>
				<div id ='teamintro'>
				</div>
				<div id ='teamheaders'>
					<div id = 'teamsum'>
					</div>
					<div id ='quicksumteam'>
					</div>
				
					<div id ='vegassumteam'>
					</div>
				</div>
				<div id ='teamresults'>		
				</div>
			</div>
		</div>
	</div> <!-- end of bottom half -->
	<div id = 'footer'>
		
	</div>
	</div><!--  end of wrapper -->


</body>
</html>