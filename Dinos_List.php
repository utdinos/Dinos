      <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="#">

                <title>Dino Quiz</title>

         <!-- Bootstrap theme -->
        <link rel="stylesheet" type="text/css" 
href="Bootstrap/css/bootstrap.css">
     <!-- Bootstrap responsive theme -->
    <link href="Bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="Bootstrap/css/theme.css" rel="stylesheet">
    <style type="text/css">

    #toggle1{
display:none;
}
#toggle2{
display:none;
}
</style>
<script 
src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js">
</script>
<!-- Below, enclosed in the script tags, is the correct Javascript 
function to make the buttons toggle. -->
<script>
$(document).ready(function(){
	$( "#1" ).click(function() {
  		$('#toggle1').toggle();
	});
	$( "#2" ).click(function() {
  		$('#toggle2').toggle();
	});
});
</script>
        </head>
APPENDIX C: Continued

<!-- Helps to read page but may cause problems depending on web browser 
-->
        <body role= "document">

    <!-- Standard navigation bar, toogle-->
     <div class="navbar navbar-inverse">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" 
data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
              <!-- need to link to homepage-->
            <a class="active" 
href="http://corvette.ischool.utexas.edu/dino/"><h1>Dino</h1></a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
               <li class="dropdown">
              <a href="#" class="dropdown-toggle" 
data-toggle="dropdown">Test Your Knowledge <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="Dinos_TaxonFC.php">Flash Cards</a></li>
                <li><a href="Dinos_List.php">Quiz</a></li>
                </li>
                </ul>
              <li><a href="Dinos_Search.php">Search</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div> <!-- end navigation bar-->

<?php
// Let's connect to the dino database...
$host = "localhost";
$user = "dino";
$password = "dinosaur";
$database = "dino";
$link = mysqli_connect($host, $user, $password, $database);

/* If the user has already submitted an answer, then one of two things 
APPENDIX C: Continued

will happen. They either got the answer right or wrong. This is what 
happens for each instance. */
if (isset($_GET['taxonguess'])) {
   $taxonguess = $_GET['taxonguess'];
   $taxonanswer = $_GET['taxonanswer'];
/* Below is a query which pulls the taxon_id from the previous page if 
there was one, and checks the user's answer for the taxon name against 
the right value. */
   $guessq = "SELECT dinotaxon.dinotaxon_id, taxon.taxon, 
dinosaur.dinosaur_id, dinosaur.dinosaur_name, dinosaur.image_url, 
taxon.taxon_id, 
dinotaxon.prime, 
characters.characters FROM dinotaxon, dinosaur, taxon, taxonchar, 
characters WHERE dinosaur.dinosaur_id=dinotaxon.dinosaur_id AND 
dinotaxon.taxon_id=taxon.taxon_id AND taxon.taxon_id=taxonchar.taxon_id 
AND taxonchar.char_id=characters.char_id AND 
taxon.taxon_id='$taxonanswer' AND 
dinotaxon.prime LIKE 'Y' ORDER BY RAND() LIMIT 1";
   $guessresult = mysqli_query($link, $guessq);
   $guess = mysqli_fetch_array($guessresult);
   $taxon = $guess['taxon'];
   if ($taxonguess == "$taxon") {
      echo "<div class='alert alert-success'><center><p>
        <strong><h3>Well done!</strong> You're right! That was 
$guess[dinosaur_name].<br/>Next question!</h3></center><br/>";
      $searchq = "SELECT dinotaxon.dinotaxon_id, dinosaur.dinosaur_id, 
dinosaur.dinosaur_name, dinosaur.image_url, taxon.taxon_id, 
dinotaxon.prime, 
characters.characters FROM dinotaxon, dinosaur, taxon, taxonchar, 
characters WHERE dinosaur.dinosaur_id=dinotaxon.dinosaur_id AND 
dinotaxon.taxon_id=taxon.taxon_id AND taxon.taxon_id=taxonchar.taxon_id 
AND taxonchar.char_id=characters.char_id AND dinotaxon.prime LIKE 'Y' 
ORDER BY 
RAND() LIMIT 1";
    $listresult = mysqli_query($link, $searchq);
    $row = mysqli_fetch_array($listresult);
/* If the user's answer was correct, the query above pulls another 
random record for a new question and the BLOCK tag below loads the page 
with this new record. */
      echo <<<BLOCK
      <div class="row">
                  <div class="container">
                        <p><img 
src="http://corvette.ischool.utexas.edu/dino/$row[image_url]" 
APPENDIX C: Continued

width="590px" 
height="auto" class="img-rounded"><p>
                </div>
        </div>
</div>

<div class="row">
                  <div class="container">
                        <form name="input" action="Dinos_List.php" 
method="get">
                        <h3 class="bg-warning"> What is the smallest 
monophyletic group that this dinosaur belongs to?</h3>
                        <input type="text" size="45" placeholder="Check 
your spelling carefully." name="taxonguess">
                        <input type="hidden" value="$row[taxon_id]" 
name="taxonanswer">
                        <input type="submit" value="submit"></p>
                        <p class="divider"></p>
                </div>
        </div>
</div>
</form>

<p class="divider"></p>
<hr>
<div class="row">
<div class= "container">
<div class="row">
</div>
<div class="row">
<div class="container">
   <p class="bg-success"><button id="1" class="btn btn-success">Need a 
Hint?</button></p>
                        <div id="toggle1" class="toggleItem">
                        <p 
class="bg-success"><strong>$row[characters]</strong></p>              
               </div>
        </div>
</div>

<div class="row">
BLOCK;
          }
/* Now, if the user's answer is wrong, we reload the page using the 
query up top where we pulled the same record from the database that was displayed 
on the previous page. This prompts the user to try again. Ultimately, they cannot 
advance to a new question if they don't get the right answer. */          
      else {
      echo "<center><div class='alert alert-danger' class='text-center'><h3><strong>Oops!</strong> Check your spelling and try submitting again.</div></h3></center><br>";
      echo <<<BLOCK
      <div class="row">
                  <div class="container">
                        <p><img 
src="http://corvette.ischool.utexas.edu/dino/$guess[image_url]" 
width="590px" 
height="auto" class="img-rounded"><p>
                </div>
        </div>
</div>

<div class="row">
                  <div class="container">
                        <form name="input" action="Dinos_List.php" 
method="get">
                        <h3 class="bg-warning"> What is the smallest 
monophyletic group that this dinosaur belongs to?</h3>
                        <input type="text" size="45" placeholder="Check 
your spelling carefully." name="taxonguess">
                        <input type="hidden" value="$guess[taxon_id]" 
name="taxonanswer">
                        <input type="submit" value="submit">
                        <p class="divider"></p>
                </div>
        </div>
</div>

</form>
<p class="divider"></p>
<hr>
<div class="row">
<div class= "container">
<div class="row">
<div class= "container">
   <p class="bg-success"><button id="1" class="btn btn-success">Need a 
Hint?</button></p>
                        <div id="toggle1" class="toggleItem">

                        <p 
class="bg-success"><strong>$guess[characters]</strong></p>
                </div>
        </div>
</div>


<div class="row">
BLOCK;
            }
   }
   else {
      
/* Finally, if no answer from a previous page was submitted, the page 
loads normally for the first time, pulling a random record.
Below is the query for the random record. It is the same as the one at 
the top that loads if you get a correct answer. */
$searchq = "SELECT dinotaxon.dinotaxon_id, dinosaur.dinosaur_id, 
dinosaur.dinosaur_name, dinosaur.image_url, taxon.taxon_id, 
dinotaxon.prime, 
characters.characters FROM dinotaxon, dinosaur, taxon, taxonchar, 
characters WHERE dinosaur.dinosaur_id=dinotaxon.dinosaur_id AND 
dinotaxon.taxon_id=taxon.taxon_id AND taxon.taxon_id=taxonchar.taxon_id 
AND taxonchar.char_id=characters.char_id AND dinotaxon.prime LIKE 'Y' 
ORDER BY 
RAND() LIMIT 1";
$listresult = mysqli_query($link, $searchq);
$row = mysqli_fetch_array($listresult);      

echo <<<BLOCK

<div class="row">
                  <div class="container">

                        <p><img 
src="http://corvette.ischool.utexas.edu/dino/$row[image_url]" 
width="590px" 
height="auto" class="img-rounded"><p>
                </div>
        </div>
</div>

<div class="row">
                  <div class="container">
                        <form name="input" action="Dinos_List.php" 
method="get">
                        <h3 class="bg-warning"> What is the smallest 
monophyletic group that this dinosaur belongs to?</h3>
                        <input type="text" size="45" placeholder="Check 
your spelling carefully." name="taxonguess">
                        <input type="hidden" value="$row[taxon_id]" 
name="taxonanswer">
                        <input type="submit" value="submit">
                        <p class="divider"></p>
                </div>
        </div>
</div>
</form>
<p class="divider"></p>
<hr>
<div class="row">
<div class= "container">
<div class="row">
<div class= "container">
</div>
</div>
<div class="row">
<div class="container">
<!-- This is the coding for the toggle button, where row[characters] is 
the hint. -->
                        <p class="bg-success"><button id="1" class="btn 
btn-success">Need a Hint?</button></p>
                        <div id="toggle1" class="toggleItem">
                        <p 
class="bg-success"><strong>$row[characters]</strong></p>
                </div>

</div>
<div class="row">
BLOCK;
}
mysqli_close($link);
?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script 

src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="Bootstrap/js/bootstrap.min.js"></script>
                <hr>
                        <div class="footer">
                                <p>&copy; Brown, Brenskelle, Carter, 
Gao, and Sayre   2014</p>
<div class="container"></div>
                </div>
       </div>
</body>
</html>
