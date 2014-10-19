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

//select the database to read from
mysql_select_db("trivia_game", $connectID)
  or die ("Unable to select database");
  
 
  
  if($_POST['qenter']){
	`$t1p = $_POST['t1points'];
   	 $t2p = $_POST['t2points'];
   	 $round= $_POST['rid'];
   	 switch ($round){
   	 	case 1:
			$rscore = "roundOneSub";
			break;
		case 2:
			$rscore = "roundTwoSub";
			break;
		case 3:
			$rscore = "roundThreeSub";
			break;
   	 }
   	 if($t1p!=0){
   	 	$_SESSION['team1SS']+= $t1p;
   	 }
   	  if($t1p!=0){
   	 	$_SESSION['team2SS']+= $t2p;
   	 }
	//$a = $_POST['answer'];
	//echo $a;
	$qid =$_POST['qid'];
	//echo $qid;
	//echo $_POST['wrong'];
	
	 mysql_query('UPDATE questions SET answeredRight=1 WHERE qID="'.$qid.'"', $connectID)
	 or die("unable to update-0");
	
	/*if($a=="wrong"){
	$currCount = mysql_fetch_array(mysql_query('SELECT countWrong FROM questions WHERE qID="'.$qid.'"', $connectID));
	$currCount[0]++;
		mysql_query('UPDATE questions SET countWrong="'.$currCount[0].'" WHERE qID="'.$qid.'"', $connectID)
		or die("Can;t update counter wrong");
	}*/
  }
?>
<body>
<?php
 include('pageintro.inc.php');

//  enter team names
//  go to round one
// same function but with a round tyoe
// round one
if(!isset($_SESSION['teams']){
	showNewTeams();
}else{
	 start();
}

function showNewTeams(){
?>
<form id="newGame" method="post" action="<?php $_SERVER['PHP_SELF'] ?>" >
	Team one name: <input type="text"  name="t1n" /><br />
	Team two name: <input type="text"  name="t2n" />
	<input type="submit" name="createTeams" value="Enter" />
</form>
	
<?php
	if($_POST['createTeams']){
	$_SESSION['teams'] = true;
	$_SESSION['team1name'] = $_POST['t1n'];
   	$_SESSION['team2name'] = $_POST['t2n'];
   	$_SESSION['team1SS'] = 0;
   	$_SESSION['team2SS'] = 0;
	
   	
   	mysql_query("INSERT into score (teamName, datePlayed) 
			     VALUES ('".$$_POST['t1n']."', '". date('m-t-y, g:i:s a e').")", $connectID)   
			    or die ("Unable to insert record into database");
		$_SESSION['team1ID'] = mysql_insert_id();
	mysql_query("INSERT into score (teamName, datePlayed) 
			     VALUES ('".$$_POST['t2n']."', '". date('m-t-y, g:i:s a e').")", $connectID)   
			    or die ("Unable to insert record into database");
		$_SESSION['team2ID'] = mysql_insert_id();
	
	
}//end shownewteams
function start(){
    echo "Your Teams are ".$_SESSION['team1'] ." and ".	$_SESSION['team2'] .""; 
   
    if(isset($_GET['r']){
    	$round=	$_GET['r'];
    		play($round);
    	}else{
    	echo "<a href=\"game.php?r=1\"> Start Round One</a> | <a href=\"game.php?r=2\"> Start Round Two</a> | <a href=\"game.php?r=3\"> Start Round Three</a>";
		}
}//end start
  
  function play($round){
  	 if($_SESSION['team1SS']<15 || $_SESSION['team2SS']<15){
  ?>
    
  
    <h2>Select a category</h2>

	
	<form id="play" method="post" action="<?php $_SERVER['PHP_SELF'] ?>" >
	<?php
	// make the  dice looking radio buttons
	$catRadio = mysql_query("SELECT * from categories", $connectID);

		while ($row = mysql_fetch_array($catRadio)) {
			echo "<span class='cat ".$row['dieColor']."'>".$row['category']."<br />\n
			<input type='radio' name='category'  value='".$row['cID']."' /></span>\n";
		}
		
	?>

<input type="submit" name="getq" value="get question" />
	</form>
	
<div id="questionoutput">
<?php

if($_POST['getq']){

	$category =$_POST['category'];
	//echo $category;
	// get all the available questions;
	$availableqs = mysql_query('SELECT qID FROM questions  WHERE catID="'.$category.'" AND answeredRight="False"', $connectID)   
			    or die ("Unable to get record from database");
	//read from database
	
	$readyqIDs = Array();
	while ($row = mysql_fetch_row($availableqs)) {
				$readyqIDs[] = $row[0];	
	}
	// randomly pick on
	echo "<br />";
		if(count($readyqIDs)>=1){
		$randy =  array_rand($readyqIDs,1);
		$qta =  $readyqIDs[$randy];

		$catID = mysql_query("SELECT category FROM categories WHERE cID='".$category."'",$connectID);
		$catName = mysql_fetch_row($catID);
		
		// gets the questions of the random id
		$questionToAsk =mysql_query("SELECT * FROM questions WHERE qID='". $qta."'",$connectID);
		// echo the table of the quesiton
		echo "<form method='post' action='".$_SERVER['PHP_SELF']."' id='question'>";
		echo "<table border='1'><caption>Randomly selected \"".$catName2[0]."\" Question</caption>";
			while ($row = mysql_fetch_array($questionToAsk)) {
			echo "<tr><td><strong>Question:</strong>".$row['question']."</td><td>Right <input type='radio' name='answer' value='right' /></td></tr>\n";
			echo "<tr><td> <strong>Answer:</strong><a href='#' id='hidAnswer'>".$row['answer']."</a></td><td>Wrong <input type='radio' name='answer' value='wrong' /></td></tr>";
			echo "<tr><td>".$_SESSION['team1name'] ."</td><td>0 pts:<input type='radio' name='t1points' value='0' checked> \n
			1 pt:<input type='radio' name='t1points' value='1'>2 pt:<input type='radio' name='t1points' value='.5'></td></tr>";
			echo "<tr><td>".$_SESSION['team2name'] ."</td><td>0 pts:<input type='radio' name='t2points' value='0' checked> \n
			1 pt:<input type='radio' name='t2points' value='1'>2 pt:<input type='radio' name='t2points' value='.5'></td></tr>";
		
			}
		echo "</table>";
		echo"<input type='hidden' name='rid' value='".$round."' />";
		echo"<input type='hidden' name='qid' value='".$qta."' />";
		echo"<input type='hidden' name='wrong' value='".$row['countWrong']."' />";
		echo "<input type='submit' name='qenter' value='enter' />";
		echo "</form>";
		
		}else{
			echo "No more available questions in this Category please select from a different category";
		}//end available qs
	}//if getq
	
	}else {
	echo "<h2> Round $round  Results</h2>"
	echo "<p>". $_SESSION['team1name'] ." has ". $_SESSION['team1SS'] ."</p>";
	 mysql_query('INSERT into score (roundOneSub) VALUES ('.$_SESSION['team1SS'].') WHERE sID = "'. $_SESSION['team1ID'].'"', $connectID);
	echo "<p>". $_SESSION['team2name'] ." has ". $_SESSION['team2SS'] ."</p>";
	 mysql_query('INSERT into score (roundOneSub) VALUES ('.$_SESSION['team2SS'].') WHERE sID = "'. $_SESSION['team2ID'].'"', $connectID);
	 
	 //testing purposes
	$myDataID = mysql_query("SELECT * from score", $connectID);
	print "<table border='1'>";
	while ($row = mysql_fetch_row($myDataID)) {
	print "<tr>";
	foreach ($row as $field) {
				print "<td> ". $field."</td>";
				}
	print "</tr>";
	}
	print "</table>";
	
	}
	
}
?>

</div><!-- end qoutput-->

<?php
 include('footer.inc.php');
?>

</body>
</html>