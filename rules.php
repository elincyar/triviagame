<?php
session_start();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Trivia Game</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	
	<link rel="stylesheet" href="triviastyles.css" type="text/css">
</head>
<?php 
include("dbconnect.inc.php");

  ?>
<body>

<?php
 include('pageintro.inc.php');


?>   
<h2>Rules</h2>
 <p>First round: first team to 15 points.  one point per right answer. group  produces one answer on paper.</p>
 <p>
  Second round:  2 teams.  first team to 15. Each person  gets a turn  to be a question leader. a correct answer gets 1 pt.  if you get help from your team members its  1/2 pt. 
	   if they get it wrong then the other team gets the OPTION to answer for 1/2 pt.  but if they get it wrong the first  team gets a 1/2 pt.
	  
</p>		   
<p>Third Round: sudden death.  on your turn you roll the dice  and answer the question.  right answer and you move to the back of the line. wrong and you are out. you earn 1 pt  for your team per correct answer.
		   5  bonus points for winning last question in sudden death.
   




<?php
 include('footer.inc.php');
?>

</body>
</html>