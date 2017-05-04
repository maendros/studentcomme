<?php 
	include("includes/db.php"); 
	
	if(isset($_GET['delete_brand'])){
	
	$delete_id = $_GET['delete_brand'];
	


	$delete_brand = $con->prepare("DELETE from brands where brand_id=:delete_id");  
		$delete_brand->execute(array(":delete_id"=>$delete_id));// delete based on id
	
	if($delete_brand){
	
	echo "<script>alert('Μια μάρκα διαγράφηκε!')</script>";
	echo "<script>window.open('index.php?view_brands','_self')</script>";
	}
	
	}





?>