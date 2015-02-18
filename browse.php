<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
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
  
  if(isset($_POST['count'])){
  	clearCount();
  }else if(isset($_POST['answers']) ){
  	clearAnswers();
  }
  
 function clearCount(){
 global $connectID;
   mysql_query('UPDATE questions SET countWrong=0', $connectID)
   or die("unable to update database");
 }
 
  function clearAnswers(){
  global $connectID;
   mysql_query('UPDATE questions SET answeredRight="False"', $connectID)
   or die("unable to update database");
 }
?>
<body>
<?php
 include('pageintro.inc.php');
	?>
 <h2>Viewing all current questions</h2>
<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" >
<input type="submit" name="count" value="Clear Wrong Answer Count" />
<input type="submit" name="answers" value="Clear Right Answers" />
</form>

<?php
 
 $all=$c1 =$c2=$c3=$c4=$c5=$c6=0;
function numberEach($a){
 global $all,$c1,$c2,$c3,$c4,$c5,$c6;
 $all++;
switch($a){
	 case 1: $c1++;
	 		break;
	 case 2: $c2++;
	 		break;
	 case 3: $c3++;
	 		break;
	 case 4: $c4++;
	 		break;
	 case 5: $c5++;
	 		break;
	 case 6: $c6++;
	 		break;
		
	}//end switch
	
	}
	

$myDataID = mysql_query("SELECT questions.question, questions.answer, questions.catID, questions.answeredRight AS AR, questions.countWrong AS CW, categories.category from questions, categories WHERE questions.catID =categories.id", $connectID)
or die (mysql_error());
	print "<table border='1'>";
	
	$i = 0;
while ($i < mysql_num_fields($myDataID)) {
    //echo "Information for column $i:<br />\n";
    $fieldName = mysql_field_name($myDataID, $i);
    
    echo "<th>".$fieldName."</th>";
    $i++;
}
	
	while ($row = mysql_fetch_row($myDataID)) {
	echo "<tr>";

	numberEach($row[2]);
	
	foreach ($row as $field) {
				print "<td> ". $field."</td>";
				}
	echo "</tr>";
	}

	echo "</tr>";
	echo "</table>";
	
		echo "All:$all<br/>Sports:$c1<br/>World Facts:$c2<br />History:$c3<br />Pop Culture:$c4<br />Science &amp; Tech:$c5<br />Misc.:$c6<br />";
	

 include('footer.inc.php');
?>

</body>
</html>