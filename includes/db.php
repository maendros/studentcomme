<?php 
try {

$con = new PDO('mysql:host=eu-cdbr-west-01.cleardb.com;dbname=heroku_e9b1067feabf696;charset=utf8mb4;', 'b6eb40152dc814', 'e850bb51');
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 }

catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

////$con = new PDO('mysql:host=localhost;dbname=id1474304_tutor;charset=utf8mb4;', 'tutor', 'tutorftw');
 ?>
