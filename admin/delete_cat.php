<?php 
	include("includes/db.php"); 
	
	if(isset($_GET['delete_cat'])){
	
	$delete_id = $_GET['delete_cat'];
	
	$delete_cat = $con->prepare("DELETE from categories where category_id=:delete_id");  
	$delete_cat->execute(array(":delete_id"=>$delete_id)); // delete based on id
	
	if($delete_cat){
	
	echo "<script>alert('Μια Κατηγορία διαγράφηκε!')</script>";
	echo "<script>window.open('index.php?view_cats','_self')</script>";
	}
	
	}





?>