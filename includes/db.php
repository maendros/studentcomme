<?php 
try {

$con = new PDO('mysql:host=localhost;dbname=ecomm;charset=utf8mb4;', 'root', '');
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 }

catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

////$con = new PDO('mysql:host=localhost;dbname=id1474304_tutor;charset=utf8mb4;', 'tutor', 'tutorftw');
 ?>
