<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link href="http://fonts.googleapis.com/css?family=Corben:bold" rel="stylesheet" type="text/css">
	<?php require($_SERVER['DOCUMENT_ROOT']."/assets/includes/header.php")?>
	
	<title>Sports Stat Grab - Contact</title>
		
		
	
			<script type ="text/javascript">  
				
				$(document).ready(function(){
				

								$("#phone").hide();

						});
	
				</script>
</head>
<body>

	
	
		
	<div id="wrappercontact">

		<div id ='toppart'>
		<h1>Sports Stat Grab!</h1>
		<div id = 'menubar'>
		<a class ='faq' href ="http://www.ilikemilktea.com">Home</a>
		 <a class ='faq' href="/welcome/faq">FAQ</a>
		 <a class ='faq' href="/welcome/contact">Contact</a>
		</div>
	</div>


		<div id ='contactform'>
			<h3>Send us any comments/concerns:</h3>
			<?php
				if (isset($message))
				echo "<div id ='errors'>" . $message ."</div>";			
				?>


			<form method ="post" action ="/welcome/submitform">

			<label>Name: </label>
				<input type ='text' name = 'name'/>
			<label>Email: </label>
				<input type ='text' name ='email' />
			<div id ='phone'>
			<label>Please don't fill this out (it is meant to stop spam) </label>
			<input type ='hidden' name ='phone'/>
			</div>
			<label>Regarding: </label>
				<input type ='text' name ='regarding' />
				<label>Comment/Question: </label>
				<textarea rows="8" cols="150" name = 'comment' placeholder='Enter text here'></textarea>
				<input type ='submit' value = 'Submit!'/>
			</form>


		</div>

	</div><!--  end of wrapper -->

</body>
</html>