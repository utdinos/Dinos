Last login: Wed Apr 23 22:05:37 on ttys000
laurabrellesmbp:~ LauraBrenskelle$ ssh lbrensk@corvette.ischool.utexas.edu
lbrensk@corvette.ischool.utexas.edu's password: 
lbrensk@corvette ~ $ mysql -p -u dino
Enter password: 
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 13931
Server version: 5.5.32-MariaDB-log Source distribution

Copyright (c) 2000, 2013, Oracle, Monty Program Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [(none)]> USE dino;
Reading table information for completion of table and column names
You can turn off this feature to get a quicker startup with -A

Database changed
MariaDB [dino]> SELECT dinotaxon.dinotaxon_id, dinosaur.dinosaur_id, dinosaur.dinosaur_name,dinosaur.image_url,
    -> taxon.taxon_id, dinotaxon.prime FROM dinotaxon, dinosaur, taxon WHERE dinotaxon.prime LIKE 'Y' ORDER BY RAND() LIMIT 1
    -> ;
+--------------+-------------+---------------+-------------------+----------+-------+
| dinotaxon_id | dinosaur_id | dinosaur_name | image_url         | taxon_id | prime |
+--------------+-------------+---------------+-------------------+----------+-------+
|            8 |          16 | Tyrannosaurus | Tyrannosaurus.jpg |       18 | Y     |
+--------------+-------------+---------------+-------------------+----------+-------+
1 row in set (0.16 sec)

MariaDB [dino]> SELECT dinotaxon.dinotaxon_id, dinosaur.dinosaur_id, dinosaur.dinosaur_name,dinosaur.image_url,
    -> taxon.taxon_id, dinotaxon.prime FROM dinotaxon, dinosaur, taxon WHERE dinotaxon.prime LIKE 'Y' ORDER BY RAND() LIMIT 1
    -> ;
+--------------+-------------+-----------------+---------------------+----------+-------+
| dinotaxon_id | dinosaur_id | dinosaur_name   | image_url           | taxon_id | prime |
+--------------+-------------+-----------------+---------------------+----------+-------+
|            8 |           7 | Parasaurolophus | Parasaurolophus.jpg |       22 | Y     |
+--------------+-------------+-----------------+---------------------+----------+-------+
1 row in set (0.15 sec)

MariaDB [dino]> SELECT dinosaur, taxon FROM dinosaur LEFT JOIN taxon on dinotaxon.taxon_id = taxon.id ORDER BY RAND() LIMIT 1;
ERROR 1054 (42S22): Unknown column 'dinosaur' in 'field list'
MariaDB [dino]> taxon.taxon_id, dinotaxon.prime FROM dinotaxon, dinosaur, taxon WHERE dinotaxon.prime LIKE 'Y' ORDER BY RAND() LIMIT 1;
ERROR 1064 (42000): You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'taxon.taxon_id, dinotaxon.prime FROM dinotaxon, dinosaur, taxon WHERE dinotaxon.' at line 1
MariaDB [dino]> SELECT dinotaxon.dinotaxon_id, dinosaur.dinosaur_id, dinosaur.dinosaur_name,dinosaur.image_url,
    -> taxon.taxon_id, dinotaxon.prime FROM dinotaxon, dinosaur, taxon WHERE dinosaur.dinosaur_id=dinotaxon.dinosaur_id AND dinotaxon.prime LIKE 'Y' ORDER BY RAND() LIMIT 1;
+--------------+-------------+---------------+-------------------+----------+-------+
| dinotaxon_id | dinosaur_id | dinosaur_name | image_url         | taxon_id | prime |
+--------------+-------------+---------------+-------------------+----------+-------+
|            3 |           3 | Scelidosaurus | Scelidosaurus.jpg |       18 | Y     |
+--------------+-------------+---------------+-------------------+----------+-------+
1 row in set (0.01 sec)

MariaDB [dino]> exit
Bye
lbrensk@corvette ~ $ cd /htdocs/dino/
lbrensk@corvette /htdocs/dino $ nano Dinos_List.php
lbrensk@corvette /htdocs/dino $ nano Dinos_List.php
lbrensk@corvette /htdocs/dino $ mysql -p -u dino
Enter password: 
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 13963
Server version: 5.5.32-MariaDB-log Source distribution

Copyright (c) 2000, 2013, Oracle, Monty Program Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [(none)]> USE dino;
Reading table information for completion of table and column names
You can turn off this feature to get a quicker startup with -A

Database changed
MariaDB [dino]> SELECT dinotaxon.dinotaxon_id, dinosaur.dinosaur_id, dinosaur.dinosaur_name, dinosaur.image_url, taxon.taxon_id, dinotaxon.prime FROM dinotaxon, dinosaur, taxon WHERE dinosaur.dinosaur_id=dinotaxon.dinosaur_id AND dinotaxon.prime LIKE 'Y' ORDER BY RAND() LIMIT 1;
+--------------+-------------+---------------+----------------+----------+-------+
| dinotaxon_id | dinosaur_id | dinosaur_name | image_url      | taxon_id | prime |
+--------------+-------------+---------------+----------------+----------+-------+
|           18 |          18 | Gallimimus    | Gallimimus.jpg |        8 | Y     |
+--------------+-------------+---------------+----------------+----------+-------+
1 row in set (0.01 sec)

MariaDB [dino]> SELECT dinotaxon.dinotaxon_id, dinosaur.dinosaur_id, dinosaur.dinosaur_name, dinosaur.image_url, taxon.taxon_id, dinotaxon.prime FROM dinotaxon, dinosaur, taxon WHERE dinosaur.dinosaur_id=dinotaxon.dinosaur_id AND dinotaxon.taxon_id=taxon.taxon_id AND dinotaxon.prime LIKE 'Y' ORDER BY RAND() LIMIT 1;
+--------------+-------------+---------------+-------------------+----------+-------+
| dinotaxon_id | dinosaur_id | dinosaur_name | image_url         | taxon_id | prime |
+--------------+-------------+---------------+-------------------+----------+-------+
|           12 |          12 | Brachiosaurus | Brachiosaurus.jpg |       14 | Y     |
+--------------+-------------+---------------+-------------------+----------+-------+
1 row in set (0.00 sec)

MariaDB [dino]> exit
Bye
lbrensk@corvette /htdocs/dino $ nano Dinos_List.php

  GNU nano 2.3.1                                    File: Dinos_List.php                                                                               

   $guess = mysqli_fetch_array($guessresult);
   $taxon = $guess['taxon'];
echo "$taxon";
   if ($taxonguess == "$taxon") {
      echo "You're right!";
      }
      else {
      echo "Sorry! Try again!";
      }
   }
   else {


$searchq = "SELECT dinotaxon.dinotaxon_id, dinosaur.dinosaur_id, dinosaur.dinosaur_name,dinosaur.image_url, taxon.taxon_id, dinotaxon.prime
FROM dinotaxon, dinosaur, taxon WHERE dinosaur.dinosaur_id=dinotaxon.dinosaur_id AND dinotaxon.taxon_id=taxon.taxon_id AND dinotaxon.prime LIKE
'Y' ORDER BY RAND() LIMIT 1";
$listresult = mysqli_query($link, $searchq);
$row = mysqli_fetch_array($listresult);

echo <<<BLOCK

<div class="row">
                  <div class="container">
                        <p><img src="http://corvette.ischool.utexas.edu/dino/$row[image_url]" width="590px"
height="auto" class="img-rounded"><p>
                </div>
        </div>
</div>

<!-- <img src="..." class="img-responsive" alt="Responsive image"> -->

<div class="row">
                  <div class="container">
                        <form name="input" action="Dinos_List.php" method="get">
                        <h3 class="bg-warning"> Which taxon does this dinosaur belong to?</h3>
                        <input type="text" size="45" placeholder="Check your spelling carefully." name="taxonguess">
                        <p class="divider"></p>
                        <input type="hidden" value="$row[taxon_id]" name="taxonanswer">
                        <p><input type="submit" value="submit"><p>
                        <p class="divider"></p>
                        <p><a href="http://corvette.ischool.utexas.edu/dino/Dinos_List.php"><button type="button" class="btn btn-sucess">Next
Question</button></a><p>
                </div>
        </div>

^G Get Help              ^O WriteOut              ^W Where Is              ^V Next Page             ^U UnCut Text            M-| First Line
^X Exit                  ^R Read File             ^Y Prev Page             ^K Cut Text              ^C Cur Pos               M-? Last Line
