<?php 
ob_start();
session_start();

session_destroy();//destroye session and back to index

                header('Location: index.php' ,true,  301 ); 
                ob_end_flush();
                exit;

 ?>