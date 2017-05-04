
<form action="" method="post" style="padding:80px;">

<b>Insert New Bran:</b>
<input type="text" name="new_brand" required/> 
<input type="submit" name="add_brand" value="Add Brand" /> 

</form>

<?php 
include("includes/db.php"); 

	if(isset($_POST['add_brand'])){
	
	$new_brand = $_POST['new_brand'];
	
	$insert_brand = $con->prepare("INSERT INTO brands(title) 
			VALUES(:new_brand)");   // insert categories
		$insert_brand->execute(array(":new_brand"=>$new_brand));
	
	if($insert_brand){
	
	echo "<script>alert('Εισήχθε νέα μάρκα!')</script>";



	echo "<script>window.open('index.php?view_brands','_self')</script>";
	}
	}

?>