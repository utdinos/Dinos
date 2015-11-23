	<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="#">

		<title>Home for Dino Web Site</title>
	
	 <!-- Bootstrap theme -->
	<link rel="stylesheet" type="text/css" href="Bootstrap/css/bootstrap.css">
     <!-- Bootstrap responsive theme -->
    <link href="Bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="Bootstrap/css/theme.css" rel="stylesheet">
	</head>
	<!-- Helps to read page but may cause problems depending on web browser -->
	<body role= "document">
	
 <!-- Standard navigation bar, toogle-->
     <div class="navbar navbar-inverse">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
              <!-- need to link to homepage-->
            <a class="active" href="index.html"><h1>Dino</h1></a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <!-- need to link to homepage section-->
               <li class="dropdown">
                 <!-- need to link to homepage section-->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Test Your Knowlegde<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <!-- need to link to Taxa webpage-->
                <li><a href="Dinos_TaxonFC.php">Flash Cards</a></li>
                <!-- need to link to Dinosaurs webpage-->
                <li><a href="Dinos_List.php">Quiz</a></li>
                </li>
                </ul>
               <!-- need to link to Search webpage-->
               <li><a href="Dinos_Search.php">Search</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div> <!-- end navigation bar-->
      
	
	
<div class="container theme-showcase" role="main">
	        
	    <!-- Search area -->
		<!-- Create dropdown list form -->
 		<div class="jumbotron">
<p class="bg-warning">Select a dinosaur to learn more:<p>
<form name="dinosaurs" method="get" action="Dinos_Search.php">
<select name="dinosaur">
   <option value="Select A Dinosaur">Select A Dinosaur</option>
   <option value="Allosaurus">Allosaurus</option>
   <option value="Archaeopteryx">Archaeopteryx</option>
   <option value="Brachiosaurus">Brachiosaurus</option>
   <option value="Carnotaurus">Carnotaurus</option>
   <option value="Dilophosaurus">Dilophosaurus</option>
   <option value="Euoplocephalus">Euoplocephlus</option>
   <option value="Gallimimus">Gallimimus</option>
   <option value="Homalocephale">Homalocephale</option>
   <option value="Hypsilophodon">Hypsilophodon</option>
   <option value="Ichthyornis">Ichthyornis</option>
   <option value="Lesothosaurus">Lesothosaurus</option>
   <option value="Oviraptor">Oviraptor</option>
   <option value="Parasaurolophus">Parasaurolophus</option>
   <option value="Plateosaurus">Plateosaurus</option>
   <option value="Psittacosaurus">Psittacosaurus</option>
   <option value="Scelidosaurus">Scelidosaurus</option>
   <option value="Stegosaurus">Stegosaurus</option>
   <option value="Syntarsus">Syntarsus</option>
   <option value="Triceratops">Triceratops</option>
   <option value="Tyrannosaurus">Tyrannosaurus</option>
   <option value="Velociraptor">Velociraptor</option>
</select>
<input type="submit" name="submit" value="Submit">
   </form>
  </div>
</div>
  
  <!-- PHP for pulling search onto this page -->

<?php
$host = "localhost";
$user = "dino";
$password = "dinosaur";
$database = "dino";
$link = mysqli_connect($host, $user, $password, $database);

//Conditionals set for nothing selected

if (isset($_GET['dinosaur'])) {
   $dinosaur= $_GET['dinosaur'];
   $dinosaur = preg_replace("/[^ 0-9a-zA-Z]+/", "", $dinosaur);
   // Use the dinosaur name to locate the dinosaur id in the dinosaur table
   $select = "SELECT dinosaur_id FROM dinosaur WHERE dinosaur_name = '$dinosaur'";
   $dinosaur_id = mysqli_query($link, $select) or die("Error: ".mysqli_error($link));
   $return = mysqli_fetch_array($dinosaur_id);
   if (empty($return)) {
       	echo "<div class='alert alert-danger' class='text-center'><strong>Oops!</strong> Please select one dinosaur.</div>";
   }
   else {
   // Use the dinosaur_id to find the relationship of this particular dinosaur, its belonging taxon and the taxon's characters
      $image_url = "SELECT image_url FROM dinosaur WHERE dinosaur_name = '$dinosaur'";
	  $image = mysqli_query($link, $image_url);
	  $display = mysqli_fetch_array($image);
      $searchq = "SELECT dinosaur_name, taxon, characters FROM dinosaur, taxon, dinotaxon, taxonchar, characters
               WHERE dinosaur.dinosaur_id = '$return[dinosaur_id]'
			   AND dinosaur.dinosaur_id = dinotaxon.dinosaur_id
			   AND taxonchar.taxon_id = dinotaxon.taxon_id
			   AND characters.char_id = taxonchar.char_id
			   AND taxonchar.taxon_id = taxon.taxon_id
			   AND dinotaxon.prime = 'Y'";
	  $listresult = mysqli_query($link, $searchq) or die ("Error: ".mysqli_error($link));
	  $result = mysqli_fetch_array($listresult);
	  
      $char = "SELECT characters FROM characters, taxonchar, dinosaur, dinotaxon, taxon
	            WHERE dinosaur.dinosaur_id = '$return[dinosaur_id]'
				AND dinosaur.dinosaur_id = dinotaxon.dinosaur_id
                AND dinotaxon.taxon_id = taxon.taxon_id
				AND taxon.taxon_id = taxonchar.taxon_id
				AND taxonchar.char_id = characters.char_id
				AND dinotaxon.prime = 'Y'
				GROUP BY characters.char_id";
	  $list_char = mysqli_query($link, $char);	
      // Print the search result    
      echo "<h2 class='text-center'>Here is your search result for $dinosaur: </h4><br>";
	  echo "<hr>";
	  echo "<h4 class='text-center'><img src = '$display[image_url]' width='590px' height='auto'></h4><br>";
	  echo "<hr>";
	  echo "<h4 class='text-center'>The taxon of $result[dinosaur_name] is $result[taxon].</h4>";
	  echo "<hr>";
	  echo "<h4 class='text-center'>$result[taxon] includes these characters: </h4>";
	  // This statement was used to display multiple characters in separate lines
	  while ($result_char = mysqli_fetch_array($list_char)) {
	       echo "<h4 class='text-center'>$result_char[characters]<br/></h4>";
	} 
}	
}
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
		</div>
</html>
