      <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="#">

                <title>Dino Flash Cards</title>

         <!-- Bootstrap theme -->
        <link rel="stylesheet" type="text/css" href="Bootstrap/css/bootstrap.css">
     <!-- Bootstrap responsive theme -->
    <link href="Bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="Bootstrap/css/theme.css" rel="stylesheet">
    <!-- jQuery Toogle which I use to first hide and then display an element: taxon -->
    <style type="text/css">
    #toggle1{
display:none;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js">
</script>
<script>
$(document).ready(function(){
  $("#1").click(function(){
    $("#toggle1").toggle();
    });
   }); 
</script>

        </head>

<!-- Helps to read page but may cause problems depending on web browser -->
        <body role= "document">

    <!-- Bootstrap CSS navigation bar, toogle-->
     <div class="navbar navbar-inverse">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
              <!--link to homepage-->
            <a class="active" href="index.html"><h1>Dino</h1></a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
               <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Test Your Knowledge<b class="caret"></b></a>
              <ul class="dropdown-menu">
               <!--link to Flash Cards-->
                <li><a href="Dinos_TaxonFC.php">Flash Cards</a></li>
                 <!--link to Quiz-->
                <li><a href="Dinos_List.php">Quiz</a></li>
                </li>
                </ul>
                 <!--link to Search-->
               <li><a href="Dinos_Search.php">Search</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div> <!-- end navigation bar-->

<!-- In order to access the information, we have the login and opening of the connection -->
<?php
$host = "localhost";
$user = "dino";
$password = "dinosaur";
$database = "dino";
$link = mysqli_connect($host, $user, $password, $database);

//Randomize the information pulled but make sure it is all associated; some is hidden for verifying the correct answer
$rand = RAND(1,25);

//only relevant data pulled from the database; Laura determined which ones apply to this question
$input = array("1", "4", "7", "12", "9", "13", "17", "21", "25");
$rand_key = array_rand($input);
$randtax = $input[$rand_key];

//our retrieved data from our tables
//since this website will be used in the future, certain changes to what is displayed for the flashcards such as hints or dinosaur names could be included
$searchq = "SELECT dinotaxon.dinotaxon_id, dinosaur.dinosaur_id, dinosaur.dinosaur_name, dinosaur.image_url, taxon.taxon_id, taxon.taxon, dinotaxon.prime FROM dinotaxon, dinosaur, 
taxon WHERE dinosaur.dinosaur_id=dinotaxon.dinosaur_id AND dinotaxon.taxon_id=taxon.taxon_id AND taxon.taxon_id LIKE (?) GROUP BY dinosaur.dinosaur_id ORDER BY RAND()";
$listresult = mysqli_prepare($link, $searchq);
// Below command binds variables for the parameter markers in the SQL statement that was passed to above command
//corresponding variable type string so use letter s
mysqli_stmt_bind_param($listresult, 's', $randtax);
mysqli_stmt_bind_result($listresult, $dinotaxon_id, $dinosaur_id, $dinosaur_name, $image_url, $taxon_id, $taxon, $prime);
mysqli_stmt_execute($listresult);
// Once it is prepared and determined to be correct, then it can be executed
//The above protects this page from mysqli injections
?>
<!--The php and html are seperated to ensure that even if a problem arises with the query, something appears on the page-->
<!--In addition, it is easier to read the code and find errors when the two are separated.-->
<div class="row">
    <div class="container">                 
		<?php
		while (mysqli_stmt_fetch($listresult)){
		//echo $dinosaur_name, $dinosaur_id ; //this is for our group reference to make sure they are pulling correctly; users will not see the id
		//This step is the first
		?>
		<!--Image of the dinos which corresponds with the taxon-->
 		<img height='200' width='auto' src='http://corvette.ischool.utexas.edu/dino/<?=$image_url;?>'> 
		<?php
		}
		?>
    </div>
</div>

<div class="row">
    <div class="container">
                <h3 class="bg-warning"> What is the monophyletic group these dinosaurs all belong to?</h3>
			<p class="divider"></p>
    		<!-- jQuery Toogle which I use to first hide and then display an element: taxon --> 
			<p class="bg-success"><button id="1" class="btn btn-success">Answer</button></p>
				<div id="toggle1" class="container">
				<!--Taxon of the dinos which corresponds with the image(s) above-->
				<p class="bg-success"><strong><?php echo $taxon;?></strong></p> 
				</div>
			<p class="divider"></p>
			<hr>	
			<!--refreshes page so that a new question is displayed; better choice that running the same query twice in two different places in one file--> 
            <p><a href="http://corvette.ischool.utexas.edu/dino/Dinos_TaxonFC.php"><button type="button" class="btn btn-sucess" action="#">Next Question</button></a><p>
    </div>
</div>
<p class="divider"></p>

<?php 
mysqli_stmt_close($listresult);
mysqli_close($link);
?>


</body>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="Bootstrap/js/bootstrap.min.js"></script>
	</body>
		<hr>
			<div class="footer">
				<p>&copy; Brown, Brenskelle, Carter, Gao, and Sayre   2014</p>
			</div>
</html>
